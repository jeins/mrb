CREATE TABLE mrb_userlogin(
  user_id INT AUTO_INCREMENT,
  username VARCHAR(100) NOT NULL,
  keylog VARBINARY(255) NOT NULL,
  keydoc VARCHAR(32) NOT NULL,
  groupliqo VARCHAR(2) NOT NULL,
  PRIMARY KEY(user_id)
);