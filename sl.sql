CREATE TABLE IF NOT EXISTS payment(
  id_payment INT NOT NULL AUTO_INCREMENT,
  id_payment_order INT NOT NULL,
  PRIMARY KEY (id_payment),
  CONSTRAINT fk_payment_payment_order
    FOREIGN KEY (id_payment_order)
    REFERENCES payment_order (id_payment_order)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS user_type(
  id_user_type INT NOT NULL AUTO_INCREMENT,
  name_type VARCHAR(45) NULL,
  PRIMARY KEY (id_user_type))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS user_address(
  id_client_address INT NOT NULL AUTO_INCREMENT,
  cep INT NULL,
  street VARCHAR(100) NULL,
  number INT NULL,
  district VARCHAR(100) NULL,
  city VARCHAR(45) NULL,
  state VARCHAR(45) NULL,
  country VARCHAR(45) NULL,
  PRIMARY KEY (id_client_address))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS login(
  id_login INT NOT NULL AUTO_INCREMENT,
  date_login INT NOT NULL,
  PRIMARY KEY (id_login))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS user(
  id_user INT NOT NULL AUTO_INCREMENT,
  id_user_type INT NOT NULL,
  id_client_address INT NOT NULL,
  id_login INT NOT NULL,
  id_log INT NOT NULL,
  firstname VARCHAR(45) NULL,
  lastname VARCHAR(45) NULL,
  cpf INT NULL,
  rg INT NULL,
  PRIMARY KEY (id_user),
  CONSTRAINT fk_user_user_type
    FOREIGN KEY (id_user_type)
    REFERENCES user_type (id_user_type)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT fk_user_user_address
    FOREIGN KEY (id_client_address)
    REFERENCES user_address (id_client_address)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT fk_user_login
    FOREIGN KEY (id_login)
    REFERENCES login (id_login)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB;

CREATE INDEX fk_user_user_type_idx ON user (id_user_type ASC);
CREATE INDEX fk_user_user_address_idx ON user (id_client_address ASC);
CREATE INDEX fk_user_login_idx ON user (id_login ASC);

CREATE TABLE IF NOT EXISTS tutorial_type(
  id_tutorial_type INT NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (id_tutorial_type))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS payment_type(
  id_payment_type INT NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (id_payment_type))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS payment_order(
  id_payment_order INT NOT NULL AUTO_INCREMENT,
  id_payment_type INT NOT NULL,
  PRIMARY KEY (id_payment_order),
  CONSTRAINT fk_payment_order_payment_type
    FOREIGN KEY (id_payment_type)
    REFERENCES payment_type (id_payment_type)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB;

CREATE INDEX fk_payment_order_payment_type_idx ON payment_order (id_payment_type ASC);

CREATE TABLE IF NOT EXISTS tutorial(
  id_tutorial INT NOT NULL,
  id_payment_order INT NOT NULL,
  id_payment_type INT NOT NULL,
  PRIMARY KEY (id_tutorial),
  CONSTRAINT fk_tutorial_type_has_user_tutorial_type
    FOREIGN KEY (id_tutorial)
    REFERENCES tutorial_type (id_tutorial_type)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_tutorial_type_has_user_payment_order
    FOREIGN KEY (id_payment_order)
    REFERENCES payment_order (id_payment_order)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB;

CREATE INDEX fk_tutorial_type_has_user_tutorial_type_idx ON tutorial (id_tutorial ASC);
CREATE INDEX fk_tutorial_type_has_user_payment_order_idx ON tutorial (id_payment_order ASC);

CREATE TABLE IF NOT EXISTS tutorial_item(
  id_tutorial_item INT NOT NULL AUTO_INCREMENT,
  id_tutorial INT NOT NULL,
  PRIMARY KEY (id_tutorial_item),
  CONSTRAINT fk_tutorial_item_tutorial
    FOREIGN KEY (id_tutorial)
    REFERENCES tutorial (id_tutorial)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB;

CREATE INDEX fk_tutorial_item_tutorial1_idx ON tutorial_item (id_tutorial ASC);

CREATE TABLE IF NOT EXISTS user_interest(
  id_user_interest INT NOT NULL AUTO_INCREMENT,
  id_user INT NOT NULL,
  PRIMARY KEY (id_user_interest),
  CONSTRAINT fk_user_interest_user
    FOREIGN KEY (id_user)
    REFERENCES user (id_user)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB;

CREATE INDEX fk_user_interest_user_idx ON user_interest (id_user ASC);

CREATE TABLE IF NOT EXISTS user_permission(
  id_user_permission INT NOT NULL AUTO_INCREMENT,
  id_user INT NOT NULL,
  id_user_type INT NOT NULL,
  id_client_address INT NOT NULL,
  PRIMARY KEY (id_user_permission),
  CONSTRAINT fk_user_permission_user
    FOREIGN KEY (id_user)
    REFERENCES user (id_user)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB;

CREATE INDEX fk_user_permission_user_idx ON user_permission (id_user ASC);

CREATE TABLE IF NOT EXISTS log_controller(
  id_log_controller INT NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (id_log_controller))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS colaborator_type(
  id_colaborator_type INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(45) NULL,
  PRIMARY KEY (id_colaborator_type))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS colaborator_address(
  id_colaborator_address INT NOT NULL AUTO_INCREMENT,
  cep INT NULL,
  street VARCHAR(100) NULL,
  number INT NULL,
  district VARCHAR(100) NULL,
  city VARCHAR(45) NULL,
  state VARCHAR(45) NULL,
  country VARCHAR(45) NULL,
  PRIMARY KEY (id_colaborator_address))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS colaborator(
  id_colaborator INT NOT NULL AUTO_INCREMENT,
  id_colaborator_type INT NOT NULL,
  id_colaborator_address INT NOT NULL,
  cnpj INT NULL,
  name VARCHAR(45) NULL,
  PRIMARY KEY (id_colaborator),
  CONSTRAINT fk_colaborator_colaborator_type
    FOREIGN KEY (id_colaborator_type)
    REFERENCES colaborator_type (id_colaborator_type)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT fk_colaborator_colaborator_address
    FOREIGN KEY (id_colaborator_address)
    REFERENCES colaborator_address (id_colaborator_address)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB;

CREATE INDEX fk_colaborator_colaborator_type_idx ON colaborator (id_colaborator_type ASC);
CREATE INDEX fk_colaborator_colaborator_address1_idx ON colaborator (id_colaborator_address ASC);

CREATE TABLE IF NOT EXISTS log(
  id_log INT NOT NULL AUTO_INCREMENT,
  id_log_controller INT NOT NULL,
  id_colaborator INT NOT NULL,
  id_login INT NOT NULL,
  PRIMARY KEY (id_log),
  CONSTRAINT fk_log_log_controller
    FOREIGN KEY (id_log_controller)
    REFERENCES log_controller (id_log_controller)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT fk_log_colaborator
    FOREIGN KEY (id_colaborator)
    REFERENCES colaborator (id_colaborator)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT fk_log_login
    FOREIGN KEY (id_login)
    REFERENCES login (id_login)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB;

CREATE INDEX fk_log_log_controller_idx ON log (id_log_controller ASC);
CREATE INDEX fk_log_colaborator1_idx ON log (id_colaborator ASC);
CREATE INDEX fk_log_login1_idx ON log (id_login ASC);

CREATE TABLE IF NOT EXISTS payment_order_has_colaborator(
  id_payment_order INT NOT NULL,
  id_payment_type INT NOT NULL,
  id_colaborator INT NOT NULL,
  id_colaborator_type INT NOT NULL,
  PRIMARY KEY (id_payment_order),
  CONSTRAINT fk_payment_order_has_colaborator_payment_order
    FOREIGN KEY (id_payment_order)
    REFERENCES payment_order (id_payment_order)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT fk_payment_order_has_colaborator_colaborator
    FOREIGN KEY (id_colaborator)
    REFERENCES colaborator (id_colaborator)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB;

CREATE INDEX fk_payment_order_has_colaborator_colaborator_idx ON payment_order_has_colaborator (id_colaborator ASC);
CREATE INDEX fk_payment_order_has_colaborator_payment_order_idx ON payment_order_has_colaborator (id_payment_order ASC);

CREATE TABLE IF NOT EXISTS payment(
  id_payment INT NOT NULL AUTO_INCREMENT,
  id_payment_order INT NOT NULL,
  PRIMARY KEY (id_payment),
  CONSTRAINT fk_payment_payment_order
    FOREIGN KEY (id_payment_order)
    REFERENCES payment_order (id_payment_order)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB;

CREATE INDEX fk_payment_payment_order_idx ON payment (id_payment_order ASC);

CREATE TABLE IF NOT EXISTS view_tutorial(
  id_view_tutorial INT NOT NULL AUTO_INCREMENT,
  id_user INT NOT NULL,
  id_payment INT NOT NULL,
  PRIMARY KEY (id_view_tutorial),
  CONSTRAINT fk_view_tutorial_user
    FOREIGN KEY (id_user)
    REFERENCES user (id_user)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT fk_view_tutorial_payment
    FOREIGN KEY (id_payment)
    REFERENCES payment (id_payment)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB;

CREATE INDEX fk_view_tutorial_user_idx ON view_tutorial (id_user ASC);
CREATE INDEX fk_view_tutorial_payment_idx ON view_tutorial (id_payment ASC);
