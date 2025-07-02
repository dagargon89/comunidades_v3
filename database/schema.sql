-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS = @@UNIQUE_CHECKS, UNIQUE_CHECKS = 0;

SET
    @OLD_FOREIGN_KEY_CHECKS = @@FOREIGN_KEY_CHECKS,
    FOREIGN_KEY_CHECKS = 0;

SET
    @OLD_SQL_MODE = @@SQL_MODE,
    SQL_MODE = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8;

-- -----------------------------------------------------
-- Schema project_management
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `project_management` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ========= INICIO DE LAS TABLAS ORIGINALES =========

-- -----------------------------------------------------
-- Table `project_management`.`axes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `project_management`.`axes` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(500) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `mydb`.`organizations`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`organizations` (
    `id` INT NOT NULL,
    `name` VARCHAR(500) NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `mydb`.`financiers`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`financiers` (
    `id` INT NOT NULL,
    `name` VARCHAR(500) NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `project_management`.`responsibles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `project_management`.`responsibles` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci' NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `name` (`name` ASC) VISIBLE
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `project_management`.`polygons`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `project_management`.`polygons` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `description` TEXT CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `name` (`name` ASC) VISIBLE
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `project_management`.`data_collectors`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `project_management`.`data_collectors` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `phone` VARCHAR(20) NULL DEFAULT NULL,
    `active` TINYINT(1) NULL DEFAULT '1',
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `name` (`name` ASC) VISIBLE
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `project_management`.`projects`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `project_management`.`projects` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(500) CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci' NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `background` TEXT NULL,
    `justification` TEXT NULL,
    `general_objective` TEXT NULL,
    `financiers_id` INT NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `fk_projects_financiers1_idx` (`financiers_id` ASC) VISIBLE,
    CONSTRAINT `fk_projects_financiers1` FOREIGN KEY (`financiers_id`) REFERENCES `mydb`.`financiers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `project_management`.`specific_objectives`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `project_management`.`specific_objectives` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `description` TEXT CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `projects_id` INT NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `fk_specific_objectives_projects1_idx` (`projects_id` ASC) VISIBLE,
    CONSTRAINT `fk_specific_objectives_projects1` FOREIGN KEY (`projects_id`) REFERENCES `project_management`.`projects` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `mydb`.`Program`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Program` (
    `id` INT NOT NULL,
    `axes_id` INT NOT NULL,
    `name` VARCHAR(500) NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `fk_Program_axes_idx` (`axes_id` ASC) VISIBLE,
    CONSTRAINT `fk_Program_axes` FOREIGN KEY (`axes_id`) REFERENCES `project_management`.`axes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `mydb`.`action_lines`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`action_lines` (
    `id` INT NOT NULL,
    `name` VARCHAR(500) NOT NULL,
    `Program_id` INT NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `fk_action_lines_Program1_idx` (`Program_id` ASC) VISIBLE,
    CONSTRAINT `fk_action_lines_Program1` FOREIGN KEY (`Program_id`) REFERENCES `mydb`.`Program` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `mydb`.`components`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`components` (
    `id` INT NOT NULL,
    `name` VARCHAR(45) NULL,
    `action_lines_id` INT NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `fk_components_action_lines1_idx` (`action_lines_id` ASC) VISIBLE,
    CONSTRAINT `fk_components_action_lines1` FOREIGN KEY (`action_lines_id`) REFERENCES `mydb`.`action_lines` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `project_management`.`goals`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `project_management`.`goals` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `description` TEXT CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT NULL,
    `number` INT NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `components_id` INT NOT NULL,
    `organizations_id` INT NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `fk_goals_components1_idx` (`components_id` ASC) VISIBLE,
    INDEX `fk_goals_organizations1_idx` (`organizations_id` ASC) VISIBLE,
    CONSTRAINT `fk_goals_components1` FOREIGN KEY (`components_id`) REFERENCES `mydb`.`components` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_goals_organizations1` FOREIGN KEY (`organizations_id`) REFERENCES `mydb`.`organizations` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `project_management`.`activities`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `project_management`.`activities` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `specific_objective_id` INT NOT NULL,
    `responsible_id` INT NOT NULL,
    `description` TEXT CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `goals_id` INT NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `idx_activities_responsible` (`responsible_id` ASC) VISIBLE,
    INDEX `idx_activities_specific_objective` (`specific_objective_id` ASC) VISIBLE,
    INDEX `fk_activities_goals1_idx` (`goals_id` ASC) VISIBLE,
    CONSTRAINT `activities_ibfk_1` FOREIGN KEY (`specific_objective_id`) REFERENCES `project_management`.`specific_objectives` (`id`) ON DELETE CASCADE,
    CONSTRAINT `activities_ibfk_2` FOREIGN KEY (`responsible_id`) REFERENCES `project_management`.`responsibles` (`id`) ON DELETE RESTRICT,
    CONSTRAINT `fk_activities_goals1` FOREIGN KEY (`goals_id`) REFERENCES `project_management`.`goals` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `project_management`.`locations`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `project_management`.`locations` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(150) NOT NULL,
    `category` VARCHAR(50) NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `Street` TEXT NULL,
    `neighborhood` VARCHAR(100) NULL,
    `ext_number` INT NULL,
    `int_number` INT NULL,
    `google_place_id` VARCHAR(500) NULL,
    `polygons_id` INT NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `name` (`name` ASC) VISIBLE,
    INDEX `fk_locations_polygons1_idx` (`polygons_id` ASC) VISIBLE,
    CONSTRAINT `fk_locations_polygons1` FOREIGN KEY (`polygons_id`) REFERENCES `project_management`.`polygons` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `project_management`.`activity_calendar`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `project_management`.`activity_calendar` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `activity_id` INT NOT NULL,
    `start_date` DATE NULL DEFAULT NULL,
    `end_date` DATE NULL DEFAULT NULL,
    `start_hour` TIME NULL DEFAULT NULL,
    `end_hour` TIME NULL DEFAULT NULL,
    `address_backup` TEXT CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT NULL,
    `last_modified` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `cancelled` TINYINT(1) NULL DEFAULT '0',
    `change_reason` TEXT CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `locations_id` INT NOT NULL,
    `data_collectors_id` INT NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `idx_activity_calendar_activity` (`activity_id` ASC) VISIBLE,
    INDEX `fk_activity_calendar_locations1_idx` (`locations_id` ASC) VISIBLE,
    INDEX `fk_activity_calendar_data_collectors1_idx` (`data_collectors_id` ASC) VISIBLE,
    CONSTRAINT `activity_calendar_ibfk_1` FOREIGN KEY (`activity_id`) REFERENCES `project_management`.`activities` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_activity_calendar_locations1` FOREIGN KEY (`locations_id`) REFERENCES `project_management`.`locations` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_activity_calendar_data_collectors1` FOREIGN KEY (`data_collectors_id`) REFERENCES `project_management`.`data_collectors` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `project_management`.`activity_files`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `project_management`.`activity_files` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `activity_id` INT NOT NULL,
    `month` VARCHAR(20) NULL DEFAULT NULL,
    `type` VARCHAR(100) NULL DEFAULT NULL,
    `file_path` TEXT CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT NULL,
    `upload_date` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    INDEX `idx_activity_files_activity` (`activity_id` ASC) VISIBLE,
    CONSTRAINT `activity_files_ibfk_2` FOREIGN KEY (`activity_id`) REFERENCES `project_management`.`activities` (`id`) ON DELETE CASCADE
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `project_management`.`beneficiary_registry`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `project_management`.`beneficiary_registry` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `activity_id` INT NOT NULL,
    `last_name` VARCHAR(100) NULL DEFAULT NULL,
    `mother_last_name` VARCHAR(100) NULL DEFAULT NULL,
    `first_names` VARCHAR(100) NULL DEFAULT NULL,
    `birth_year` VARCHAR(4) NULL DEFAULT NULL,
    `gender` ENUM('M', 'F', 'Male', 'Female') NULL DEFAULT NULL,
    `phone` VARCHAR(20) NULL DEFAULT NULL,
    `signature` TEXT CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT NULL,
    `data_collector_id` INT NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `address_backup` TEXT NULL,
    `locations_id` INT NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `data_collector_id` (`data_collector_id` ASC) VISIBLE,
    INDEX `idx_beneficiary_registry_activity` (`activity_id` ASC) VISIBLE,
    INDEX `fk_beneficiary_registry_locations1_idx` (`locations_id` ASC) VISIBLE,
    CONSTRAINT `beneficiary_registry_ibfk_2` FOREIGN KEY (`activity_id`) REFERENCES `project_management`.`activities` (`id`) ON DELETE CASCADE,
    CONSTRAINT `beneficiary_registry_ibfk_3` FOREIGN KEY (`data_collector_id`) REFERENCES `project_management`.`data_collectors` (`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_beneficiary_registry_locations1` FOREIGN KEY (`locations_id`) REFERENCES `project_management`.`locations` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `project_management`.`planned_metrics`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `project_management`.`planned_metrics` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `activity_id` INT NOT NULL,
    `description` TEXT NULL,
    `unit` VARCHAR(100) NULL DEFAULT NULL,
    `year` INT NULL DEFAULT NULL,
    `month` INT NULL DEFAULT NULL,
    `is_product` TINYINT(1) NULL DEFAULT 0,
    `is_population` TINYINT(1) NULL DEFAULT 0,
    `population_target_value` DECIMAL(10, 2) NULL DEFAULT NULL,
    `population_real_value` DECIMAL(10, 2) NULL DEFAULT '0.00',
    `product_target_value` DECIMAL(10, 2) NULL DEFAULT NULL,
    `product_real_value` DECIMAL(10, 2) NULL DEFAULT NULL,
    `data_collector_id` INT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    INDEX `idx_planned_metrics_activity_period` (
        `activity_id` ASC,
        `year` ASC,
        `month` ASC
    ) VISIBLE,
    CONSTRAINT `planned_metrics_ibfk_2` FOREIGN KEY (`activity_id`) REFERENCES `project_management`.`activities` (`id`) ON DELETE CASCADE
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `mydb`.`kpi`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`kpi` (
    `id` INT NOT NULL,
    `name` VARCHAR(50) NULL,
    `description` TEXT NULL,
    `initial_value` DECIMAL(10, 2) NULL,
    `final_value` DECIMAL(10, 2) NULL,
    `projects_id` INT NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `fk_kpi_projects1_idx` (`projects_id` ASC) VISIBLE,
    CONSTRAINT `fk_kpi_projects1` FOREIGN KEY (`projects_id`) REFERENCES `project_management`.`projects` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `mydb`.`program_indicators`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`program_indicators` (
    `id` INT NOT NULL,
    `name` VARCHAR(45) NULL,
    `description` TEXT NULL,
    `initial_value` DECIMAL(10, 2) NULL,
    `final_value` DECIMAL(10, 2) NULL,
    `Program_id` INT NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `fk_program_indicators_Program1_idx` (`Program_id` ASC) VISIBLE,
    CONSTRAINT `fk_program_indicators_Program1` FOREIGN KEY (`Program_id`) REFERENCES `mydb`.`Program` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- ========= INICIO DEL GREMIO DE GUARDIANES (USUARIOS Y ROLES) =========

-- -----------------------------------------------------
-- Table `project_management`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `project_management`.`users` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(50) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `password_hash` VARCHAR(255) NOT NULL,
    `first_name` VARCHAR(100) NULL,
    `last_name` VARCHAR(100) NULL,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `username_UNIQUE` (`username` ASC) VISIBLE,
    UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `project_management`.`roles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `project_management`.`roles` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(50) NOT NULL,
    `description` TEXT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `name_UNIQUE` (`name` ASC) VISIBLE
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `project_management`.`permissions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `project_management`.`permissions` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL COMMENT 'Ej: project.create, activity.delete',
    `description` TEXT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `name_UNIQUE` (`name` ASC) VISIBLE
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `project_management`.`user_roles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `project_management`.`user_roles` (
    `user_id` INT NOT NULL,
    `role_id` INT NOT NULL,
    PRIMARY KEY (`user_id`, `role_id`),
    INDEX `fk_user_roles_roles1_idx` (`role_id` ASC) VISIBLE,
    CONSTRAINT `fk_user_roles_users1` FOREIGN KEY (`user_id`) REFERENCES `project_management`.`users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_user_roles_roles1` FOREIGN KEY (`role_id`) REFERENCES `project_management`.`roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `project_management`.`role_permissions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `project_management`.`role_permissions` (
    `role_id` INT NOT NULL,
    `permission_id` INT NOT NULL,
    PRIMARY KEY (`role_id`, `permission_id`),
    INDEX `fk_role_permissions_permissions1_idx` (`permission_id` ASC) VISIBLE,
    CONSTRAINT `fk_role_permissions_roles1` FOREIGN KEY (`role_id`) REFERENCES `project_management`.`roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_role_permissions_permissions1` FOREIGN KEY (`permission_id`) REFERENCES `project_management`.`permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

-- ========= INICIO DE LAS INTEGRACIONES CON EL GREMIO =========

ALTER TABLE `project_management`.`responsibles`
ADD COLUMN `user_id` INT NULL DEFAULT NULL AFTER `name`,
ADD INDEX `fk_responsibles_users1_idx` (`user_id` ASC) VISIBLE;

ALTER TABLE `project_management`.`responsibles`
ADD CONSTRAINT `fk_responsibles_users1` FOREIGN KEY (`user_id`) REFERENCES `project_management`.`users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `project_management`.`data_collectors`
ADD COLUMN `user_id` INT NULL DEFAULT NULL AFTER `phone`,
ADD INDEX `fk_data_collectors_users1_idx` (`user_id` ASC) VISIBLE;

ALTER TABLE `project_management`.`data_collectors`
ADD CONSTRAINT `fk_data_collectors_users1` FOREIGN KEY (`user_id`) REFERENCES `project_management`.`users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

-- ========= INICIO DE LAS VISTAS MÁGICAS =========

-- -----------------------------------------------------
-- View `project_management`.`vw_activity_summary`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `project_management`.`vw_activity_summary`;

USE `project_management`;

CREATE
OR
REPLACE
    ALGORITHM = UNDEFINED DEFINER = `root` @`localhost` SQL SECURITY DEFINER VIEW `project_management`.`vw_activity_summary` AS
SELECT
    a.id AS activity_id,
    a.description AS activity_name,
    so.id AS specific_objective_id,
    so.description AS objective_description,
    p.id AS project_id,
    p.name AS project_name,
    ax.id AS axis_id,
    ax.name AS axis_name,
    r.id AS responsible_id,
    r.name AS responsible_name,
    org.name AS organization,
    ac.start_date AS start_date,
    ac.end_date AS end_date,
    pol.name AS polygon_name,
    loc.name AS location_name,
    dc.name AS data_collector_name,
    (
        SELECT COUNT(*)
        FROM planned_metrics pm_prod
        WHERE
            pm_prod.activity_id = a.id
            AND pm_prod.is_product = 1
    ) AS products_count,
    (
        SELECT COUNT(*)
        FROM planned_metrics pm_pop
        WHERE
            pm_pop.activity_id = a.id
            AND pm_pop.is_population = 1
    ) AS population_count,
    (
        SELECT COUNT(*)
        FROM beneficiary_registry br
        WHERE
            br.activity_id = a.id
    ) AS beneficiaries_count
FROM
    `project_management`.`activities` `a`
    JOIN `project_management`.`responsibles` `r` ON a.responsible_id = r.id
    JOIN `project_management`.`specific_objectives` `so` ON a.specific_objective_id = so.id
    JOIN `project_management`.`projects` `p` ON so.projects_id = p.id
    JOIN `project_management`.`goals` `g` ON a.goals_id = g.id
    JOIN `mydb`.`organizations` `org` ON g.organizations_id = org.id
    JOIN `mydb`.`components` `c` ON g.components_id = c.id
    JOIN `mydb`.`action_lines` `al` ON c.action_lines_id = al.id
    JOIN `mydb`.`Program` `prog` ON al.Program_id = prog.id
    JOIN `project_management`.`axes` `ax` ON prog.axes_id = ax.id
    LEFT JOIN `project_management`.`activity_calendar` `ac` ON a.id = ac.activity_id
    AND ac.cancelled = 0
    LEFT JOIN `project_management`.`locations` `loc` ON ac.locations_id = loc.id
    LEFT JOIN `project_management`.`polygons` `pol` ON loc.polygons_id = pol.id
    LEFT JOIN `project_management`.`data_collectors` `dc` ON ac.data_collectors_id = dc.id
GROUP BY
    a.id,
    r.id,
    so.id,
    p.id,
    ax.id,
    org.name,
    ac.start_date,
    ac.end_date,
    pol.name,
    loc.name,
    dc.name;

-- -----------------------------------------------------
-- View `project_management`.`vw_planned_population`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `project_management`.`vw_planned_population`;

USE `project_management`;

CREATE
OR
REPLACE
    ALGORITHM = UNDEFINED DEFINER = `root` @`localhost` SQL SECURITY DEFINER VIEW `project_management`.`vw_planned_population` AS
SELECT
    pm.id,
    a.specific_objective_id,
    pm.activity_id,
    a.responsible_id,
    pm.is_product,
    pm.is_population,
    pm.description,
    pm.unit,
    pm.year,
    pm.month,
    pm.population_target_value as target_value,
    pm.population_real_value as real_value,
    pm.data_collector_id,
    pm.created_at,
    pm.updated_at,
    a.description AS activity_name,
    r.name AS responsible_name
FROM `project_management`.`planned_metrics` `pm`
    JOIN `project_management`.`activities` `a` ON pm.activity_id = a.id
    JOIN `project_management`.`responsibles` `r` ON a.responsible_id = r.id
WHERE
    pm.is_population = 1;

-- -----------------------------------------------------
-- View `project_management`.`vw_planned_products`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `project_management`.`vw_planned_products`;

USE `project_management`;

CREATE
OR
REPLACE
    ALGORITHM = UNDEFINED DEFINER = `root` @`localhost` SQL SECURITY DEFINER VIEW `project_management`.`vw_planned_products` AS
SELECT
    pm.id,
    a.specific_objective_id,
    pm.activity_id,
    a.responsible_id,
    pm.is_product,
    pm.is_population,
    pm.description,
    pm.unit,
    pm.year,
    pm.month,
    pm.product_target_value as target_value,
    pm.product_real_value as real_value,
    pm.data_collector_id,
    pm.created_at,
    pm.updated_at,
    a.description AS activity_name,
    r.name AS responsible_name
FROM `project_management`.`planned_metrics` `pm`
    JOIN `project_management`.`activities` `a` ON pm.activity_id = a.id
    JOIN `project_management`.`responsibles` `r` ON a.responsible_id = r.id
WHERE
    pm.is_product = 1;

SET SQL_MODE = @OLD_SQL_MODE;

SET FOREIGN_KEY_CHECKS = @OLD_FOREIGN_KEY_CHECKS;

SET UNIQUE_CHECKS = @OLD_UNIQUE_CHECKS;