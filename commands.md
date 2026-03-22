ALTER TABLE users ADD status TINYINT(1) DEFAULT 1;


DEBUG INFO:
Email submitted: jude@email.com
Password submitted: ******** (length: 8)
✓ User found in database
Stored hash: $2y$10$6eRDyC.doXJ8s... (length: 57)
Hash format: ✓ bcrypt ($2y$)
password_verify result: ❌ FALSE (Password mismatch)
PHP version: 8.1.25