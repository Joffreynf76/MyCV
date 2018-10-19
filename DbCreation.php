<?php
/*
Plugin Name: DB Creation
Plugin URI: https://nfactory.school/
Description: Création base de donnée
Author: Théo Da Costa
Version: 0.1
Author URI: https://nfactory.school/
*/

class DbCreation{

    public function pluginActivation(){
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();
                $sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."user (
                    ID INT NOT NULL AUTO_INCREMENT,
                    name VARCHAR(45) NULL,
                    firstname VARCHAR(45) NULL,
                    picture VARCHAR(45) NULL,
                    birthday VARCHAR(45) NULL,
                    email VARCHAR(255) NULL,
                    password VARCHAR(200) NULL,
                    PRIMARY KEY (ID))$charset_collate";
                    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

                      dbDelta( $sql );

                $sql = "CREATE TABLE IF NOT EXISTS ". $wpdb->prefix . "user_picture (
                    ID INT NOT NULL AUTO_INCREMENT,
                    filename VARCHAR(45) NULL,
                    user_ID INT NOT NULL,
                    PRIMARY KEY (ID, user_ID),
                    INDEX fk_user_picture_user1_idx (user_ID ASC),
                    CONSTRAINT fk_user_picture_user1
                      FOREIGN KEY (user_ID)
                      REFERENCES " . $wpdb->prefix."user (ID)
                      ON DELETE NO ACTION
                      ON UPDATE NO ACTION)$charset_collate";
                dbDelta( $sql );

                $sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."title (
                    ID INT NOT NULL AUTO_INCREMENT,
                    name VARCHAR(45) NULL,
                    PRIMARY KEY (ID))$charset_collate";
                dbDelta( $sql );

                $sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."business_field (
                    ID INT NOT NULL AUTO_INCREMENT,
                    name VARCHAR(45) NULL,
                    PRIMARY KEY (ID))$charset_collate";
                dbDelta( $sql );

                $sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."company (
                  ID INT NOT NULL AUTO_INCREMENT,
                  name VARCHAR(45) NULL,
                  location VARCHAR(45) NULL,
                  url VARCHAR(45) NULL,
                  business_field_ID INT NOT NULL,
                  PRIMARY KEY (ID, business_field_ID),
                  INDEX fk_company_business_field1_idx (business_field_ID ASC),
                  CONSTRAINT fk_company_business_field1
                    FOREIGN KEY (business_field_ID)
                    REFERENCES ".$wpdb->prefix."business_field (ID)
                    ON DELETE NO ACTION
                    ON UPDATE NO ACTION)$charset_collate";
                dbDelta( $sql );

                $sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."experiences (
                  ID INT NOT NULL AUTO_INCREMENT,
                  begin VARCHAR(45) NULL,
                  end VARCHAR(45) NULL,
                  contract_nature VARCHAR(45) NULL,
                  company_ID INT NOT NULL,
                  title_ID INT NOT NULL,
                  PRIMARY KEY (ID, title_ID, company_ID),
                  INDEX fk_experiences_title1_idx (title_ID ASC),
                  INDEX fk_experiences_company1_idx (company_ID ASC),
                  CONSTRAINT fk_experiences_title1
                    FOREIGN KEY (title_ID)
                    REFERENCES ".$wpdb->prefix."title (ID)
                    ON DELETE NO ACTION
                    ON UPDATE NO ACTION,
                  CONSTRAINT fk_experiences_company1
                    FOREIGN KEY (company_ID)
                    REFERENCES ".$wpdb->prefix."company (ID)
                    ON DELETE NO ACTION
                    ON UPDATE NO ACTION)$charset_collate";
                dbDelta( $sql );

                $sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."school (
                  ID INT NOT NULL AUTO_INCREMENT,
                  name VARCHAR(45) NULL,
                  PRIMARY KEY (ID))$charset_collate";
                dbDelta( $sql );

                $sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."qualifications (
                  ID INT NOT NULL AUTO_INCREMENT,
                  name VARCHAR(45) NULL,
                  school_ID INT NOT NULL,
                  PRIMARY KEY (ID, school_ID),
                  INDEX fk_qualifications_school1_idx (school_ID ASC),
                  CONSTRAINT fk_qualifications_school1
                    FOREIGN KEY (school_ID)
                    REFERENCES ".$wpdb->prefix."school (ID)
                    ON DELETE NO ACTION
                    ON UPDATE NO ACTION)$charset_collate";
                dbDelta( $sql );

                $sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."languages (
                  ID INT NOT NULL AUTO_INCREMENT,
                  name VARCHAR(45) NULL,
                  PRIMARY KEY (ID))$charset_collate";
                dbDelta( $sql );

                $sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."certifications (
                  ID INT NOT NULL AUTO_INCREMENT,
                  name VARCHAR(45) NULL,
                  PRIMARY KEY (ID))$charset_collate";
                dbDelta( $sql );

                $sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."visual (
                  ID INT NOT NULL AUTO_INCREMENT,
                  picture VARCHAR(45) NULL,
                  PRIMARY KEY (ID))$charset_collate";
                dbDelta( $sql );

                $sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."achievements (
                  ID INT NOT NULL AUTO_INCREMENT,
                  description VARCHAR(45) NULL,
                  url VARCHAR(45) NULL,
                  begin VARCHAR(45) NULL,
                  end VARCHAR(45) NULL,
                  role VARCHAR(45) NULL,
                  visual_ID INT NOT NULL,
                  PRIMARY KEY (ID, visual_ID),
                  INDEX fk_achievements_visual1_idx (visual_ID ASC),
                  CONSTRAINT fk_achievements_visual1
                    FOREIGN KEY (visual_ID)
                    REFERENCES ".$wpdb->prefix."visual (ID)
                    ON DELETE NO ACTION
                    ON UPDATE NO ACTION)$charset_collate";
                dbDelta( $sql );

                $sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."interest_center (
                  ID INT NOT NULL AUTO_INCREMENT,
                  name VARCHAR(45) NULL,
                  PRIMARY KEY (ID))$charset_collate";
                dbDelta( $sql );

                $sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."technology (
                  ID INT NOT NULL AUTO_INCREMENT,
                  name VARCHAR(45) NULL,
                  PRIMARY KEY (ID))$charset_collate";
                dbDelta( $sql );

                $sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."user_has_technology (
                  user_ID INT NOT NULL,
                  technology_ID INT NOT NULL,
                  level VARCHAR(45) NULL,
                  PRIMARY KEY (user_ID, technology_ID),
                  INDEX fk_user_has_technology_technology1_idx (technology_ID ASC),
                  INDEX fk_user_has_technology_user_idx (user_ID ASC),
                  CONSTRAINT fk_user_has_technology_user
                    FOREIGN KEY (user_ID)
                    REFERENCES ".$wpdb->prefix."user (ID)
                    ON DELETE NO ACTION
                    ON UPDATE NO ACTION,
                  CONSTRAINT fk_user_has_technology_technology1
                    FOREIGN KEY (technology_ID)
                    REFERENCES ".$wpdb->prefix."technology (ID)
                    ON DELETE NO ACTION
                    ON UPDATE NO ACTION)$charset_collate";
                dbDelta( $sql );

                $sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."technology_has_achievements (
                  technology_ID INT NOT NULL,
                  achievements_ID INT NOT NULL,
                  level VARCHAR(45) NULL,
                  PRIMARY KEY (technology_ID, achievements_ID),
                  INDEX fk_technology_has_achievements_achievements1_idx (achievements_ID ASC),
                  INDEX fk_technology_has_achievements_technology1_idx (technology_ID ASC),
                  CONSTRAINT fk_technology_has_achievements_technology1
                    FOREIGN KEY (technology_ID)
                    REFERENCES ".$wpdb->prefix."technology (ID)
                    ON DELETE NO ACTION
                    ON UPDATE NO ACTION,
                  CONSTRAINT fk_technology_has_achievements_achievements1
                    FOREIGN KEY (achievements_ID)
                    REFERENCES ".$wpdb->prefix."achievements (ID)
                    ON DELETE NO ACTION
                    ON UPDATE NO ACTION)$charset_collate";
                dbDelta( $sql );

                $sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."user_has_qualifications (
                  user_ID INT NOT NULL,
                  qualifications_ID INT NOT NULL,
                  year VARCHAR(45) NULL,
                  PRIMARY KEY (user_ID, qualifications_ID),
                  INDEX fk_user_has_qualifications_qualifications1_idx (qualifications_ID ASC),
                  INDEX fk_user_has_qualifications_user1_idx (user_ID ASC),
                  CONSTRAINT fk_user_has_qualifications_user1
                    FOREIGN KEY (user_ID)
                    REFERENCES ".$wpdb->prefix."user (ID)
                    ON DELETE NO ACTION
                    ON UPDATE NO ACTION,
                  CONSTRAINT fk_user_has_qualifications_qualifications1
                    FOREIGN KEY (qualifications_ID)
                    REFERENCES ".$wpdb->prefix."qualifications (ID)
                    ON DELETE NO ACTION
                    ON UPDATE NO ACTION)$charset_collate";
                dbDelta( $sql );

                $sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."user_has_languages (
                  user_ID INT NOT NULL,
                  languages_ID INT NOT NULL,
                  level VARCHAR(45) NULL,
                  PRIMARY KEY (user_ID, languages_ID),
                  INDEX fk_user_has_languages_languages1_idx (languages_ID ASC),
                  INDEX fk_user_has_languages_user1_idx (user_ID ASC),
                  CONSTRAINT fk_user_has_languages_user1
                    FOREIGN KEY (user_ID)
                    REFERENCES ".$wpdb->prefix."user (ID)
                    ON DELETE NO ACTION
                    ON UPDATE NO ACTION,
                  CONSTRAINT fk_user_has_languages_languages1
                    FOREIGN KEY (languages_ID)
                    REFERENCES ".$wpdb->prefix."languages (ID)
                    ON DELETE NO ACTION
                    ON UPDATE NO ACTION)$charset_collate";
                dbDelta( $sql );

                $sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."user_has_certifications (
                  user_ID INT NOT NULL,
                  certifications_ID INT NOT NULL,
                  year VARCHAR(45) NULL,
                  PRIMARY KEY (user_ID, certifications_ID),
                  INDEX fk_user_has_certifications_certifications1_idx (certifications_ID ASC),
                  INDEX fk_user_has_certifications_user1_idx (user_ID ASC),
                  CONSTRAINT fk_user_has_certifications_user1
                    FOREIGN KEY (user_ID)
                    REFERENCES ".$wpdb->prefix."user (ID)
                    ON DELETE NO ACTION
                    ON UPDATE NO ACTION,
                  CONSTRAINT fk_user_has_certifications_certifications1
                    FOREIGN KEY (certifications_ID)
                    REFERENCES ".$wpdb->prefix."certifications (ID)
                    ON DELETE NO ACTION
                    ON UPDATE NO ACTION)$charset_collate";
                dbDelta( $sql );

                $sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."user_has_interest_center (
                  user_ID INT NOT NULL,
                  interest_center_ID INT NOT NULL,
                  PRIMARY KEY (user_ID, interest_center_ID),
                  INDEX fk_user_has_interest_center_interest_center1_idx (interest_center_ID ASC),
                  INDEX fk_user_has_interest_center_user1_idx (user_ID ASC),
                  CONSTRAINT fk_user_has_interest_center_user1
                    FOREIGN KEY (user_ID)
                    REFERENCES ".$wpdb->prefix."user (ID)
                    ON DELETE NO ACTION
                    ON UPDATE NO ACTION,
                  CONSTRAINT fk_user_has_interest_center_interest_center1
                    FOREIGN KEY (interest_center_ID)
                    REFERENCES ".$wpdb->prefix."interest_center (ID)
                    ON DELETE NO ACTION
                    ON UPDATE NO ACTION)$charset_collate";
                dbDelta( $sql );

                $sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."user_has_title (
                  user_ID INT NOT NULL,
                  title_ID INT NOT NULL,
                  PRIMARY KEY (user_ID, title_ID),
                  INDEX fk_user_has_title_title1_idx (title_ID ASC),
                  INDEX fk_user_has_title_user1_idx (user_ID ASC),
                  CONSTRAINT fk_user_has_title_user1
                    FOREIGN KEY (user_ID)
                    REFERENCES ".$wpdb->prefix."user (ID)
                    ON DELETE NO ACTION
                    ON UPDATE NO ACTION,
                  CONSTRAINT fk_user_has_title_title1
                    FOREIGN KEY (title_ID)
                    REFERENCES ".$wpdb->prefix."title (ID)
                    ON DELETE NO ACTION
                    ON UPDATE NO ACTION)$charset_collate";
                dbDelta( $sql );
    }

}
register_activation_hook(__FILE__, array('DbCreation', 'pluginActivation'));
add_action( 'plugins_loaded', function(){
    new DbCreation();
} );
