<?php
class Query {
    public static function LOGIN_QUERY() {
        return "SELECT id, username, email, password FROM users WHERE username = ?";
    }
    
    public static function REGISTER_QUERY() {
        return "INSERT INTO users (username, email, password, created_at) VALUES (?, ?, ?, NOW())";
    }
}     