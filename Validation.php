<?php

class Validation 
{
    private $errors = array();

    // フォームによって書き換える
    public function validate($post)
    {
        $this->is_set($post['furigana'], "お名前（フリガナ）");
        $this->is_set($post['name'], "お名前");
        if ($this->is_set($post['postcode1'], "郵便番号")) {
            $this->is_numeric($post['postcode1'], "郵便番号");   
        }
        if ($this->is_set($post['postcode2'], "郵便番号")) {
            $this->is_numeric($post['postcode2'], "郵便番号");   
        }
        $this->is_set($post['prefecture'], "都道府県");
        $this->is_set($post['address'], "ご住所");
        $this->is_set($post['tel'], "お電話番号");

        if ($this->is_set($post['email1'], "メールアドレス")) {
            if ($this->is_email($post['email1'])) {
                if ($this->is_set($post['email2'], "メールアドレスの再入力")) {
                    $this->is_same($post['email1'], $post['email2'], "メールアドレスが一致していません。");
                }
            }
        }

        return $this->errors;
    }

    private function is_set($val, $name)
    {
        if (strlen($val)) {
            return true;
        } else {
            $this->errors[] = $name."を入力してください。";
        }

    }

    private function is_only_space($val,$name)
    {
        if (preg_match('/^[ 　\t\r\n]+$/', $val)) {
            $this->errors[] = $name."を入力してください。";
        } else {
            return true;
        }
    }

    private function is_null($val, $name)
    {
        $this->is_set();
    }

    private function is_email($val)
    {
        if (preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $val)) {
            return true;
        } else {
            $this->errors[] = "メールアドレスが正しくありません。";
        }
    }

    private function is_numeric($val, $name)
    {
        if (preg_match('/^[0-9０-９ \t]+$/', $val)) {
            return true;
        } else {
            $this->errors[] = $name."は数値で入力してください。";
        }
    }

    private function is_roma($val, $name)
    {
        if (preg_match('/^[a-zA-Z \t]+$/', $val)) {
            return true;
        } else {
            $this->errors[] = $name."はローマ字で入力してください。";
        }
    }

    private function is_same($val1, $val2, $message)
    {
        if ($val1 === $val2) {
            return true;
        } else {
            $this->errors[] = $message;
        }
    }
}