<?php
$password = 'admin123';
$hash = '$2y$12$UUaHQm3ufu9sE.l6IiV8p.Hobba3SNviUZcLooaj10hCkGcN/LU5S';

if (password_verify($password, $hash)) {
    echo "Password matches!\n";
} else {
    echo "Password DOES NOT match!\n";
}
