# SecureBusBooking 🚍🔐
A secure PHP-based bus ticket booking system that integrates cryptography (AES-256), secure key management, and bcrypt password hashing to protect user data and payment information. Built with a security-first mindset following secure coding practices.

---

## 🔥 Features
- ✅ User registration & authentication (secure sessions)
- ✅ Password hashing using `bcrypt`
- ✅ AES-256 encryption for sensitive data (card info)
- ✅ Secure key management system
- ✅ Protection against SQL Injection
- ✅ Protection against XSS attacks
- ✅ Input validation and sanitization
- ✅ Basic role-based access control
- ✅ MySQL database integration

---

## 🧠 Security Highlights
| Security Feature             | Technique Used                         |
|-----------------------------|----------------------------------------|
| Password Protection         | `password_hash()` with BCRYPT          |
| Data Encryption             | AES-256-CBC via `openssl_encrypt()`     |
| Key Management              | Secure file-based key storage          |
| SQL Injection Mitigation    | Prepared statements (`mysqli->prepare`)|
| XSS Prevention              | `htmlspecialchars()` output filtering  |
| Session Security            | Session hijacking prevention methods   |

---

## 🛠️ Tech Stack
- **Frontend:** HTML, CSS, JavaScript
- **Backend:** PHP
- **Database:** MySQL
- **Security:** AES, Bcrypt, Input Sanitization

---

## 📁 Project Structure
/SecureBusBooking
│
├── config.php # Database connection + password hashing
├── key_management.php # Encryption key generation & handling
├── paymentmeth.php # AES encryption/decryption for payments
├── register.php # Secure user registration
├── login.php # User authentication system
├── home.php # User dashboard
├── encryption_key.txt # AES key storage (restricted access)
└── /assets # CSS/JS/Images
---

## 🚀 Setup Instructions
### ✅ Prerequisites
- PHP 7 or higher
- MySQL
- XAMPP/LAMP/WAMP server

### ✅ Installation
1. Clone this repository:
   ```bash
   git clone https://github.com/yourusername/SecureBusBooking.git
