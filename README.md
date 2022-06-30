# Encrypter

Encrypter is a PHP class to perform 2-way encryption. It works with master password-data duals. In encrypted data, different characters are used for the repeating characters in the original data.
Please note that Encrypter only works with ASCII characters.

## Usage
```php
$encrypter = new Encrypter('master_password');

// Encrypter::encrypt() returns an array containing ASCII values of encrypted data.
$encryptedData = $encrypter->encrypt($data);

// You need to initiate with the same master password when using somewhere else
// Encrypter::decrypt() returns an array containing ASCII values of decrypted data.
$decryptedData = $encrypter->decrypt($encryptedData);
```
