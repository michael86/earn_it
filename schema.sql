-- earn_it_schema.sql
-- MySQL 8+, InnoDB, UUIDs stored as CHAR(36)
-- Safe to rerun (drops triggers and tables first)

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- Drop triggers first (so reruns never fail)
DROP TRIGGER IF EXISTS trg_tasks_bi_family_check;
DROP TRIGGER IF EXISTS trg_tasks_bu_family_check;
DROP TRIGGER IF EXISTS trg_wishes_bi_family_check;
DROP TRIGGER IF EXISTS trg_wishes_bu_family_check;
DROP TRIGGER IF EXISTS trg_points_ledger_bi_family_check;
DROP TRIGGER IF EXISTS trg_points_ledger_bu_family_check;
DROP TRIGGER IF EXISTS trg_task_proofs_bi_family_check;
DROP TRIGGER IF EXISTS trg_task_proofs_bu_family_check;
DROP TRIGGER IF EXISTS trg_tasks_bi_status_integrity;
DROP TRIGGER IF EXISTS trg_tasks_bu_status_integrity;

-- Drop tables (children first)
DROP TABLE IF EXISTS points_ledger;
DROP TABLE IF EXISTS task_proofs;
DROP TABLE IF EXISTS tasks;
DROP TABLE IF EXISTS wishes;
DROP TABLE IF EXISTS family_invites;
DROP TABLE IF EXISTS user_sessions;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS families;

SET FOREIGN_KEY_CHECKS = 1;

-- =========================
-- Tables
-- =========================

CREATE TABLE families (
    id CHAR(36) NOT NULL PRIMARY KEY,
    name VARCHAR(150) NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE users (
    id CHAR(36) NOT NULL PRIMARY KEY,
    family_id CHAR(36) NOT NULL,
    role ENUM('parent','child') NOT NULL,
    display_name VARCHAR(120) NOT NULL,

    email VARCHAR(255) NULL,
    password VARCHAR(255) NULL,

    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    UNIQUE KEY uq_users_email (email),
    KEY idx_users_family_id (family_id),
    KEY idx_users_role (role),

    CONSTRAINT fk_users_family
        FOREIGN KEY (family_id) REFERENCES families(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE tasks (
    id CHAR(36) NOT NULL PRIMARY KEY,
    family_id CHAR(36) NOT NULL,

    assigned_by_user_id CHAR(36) NOT NULL,
    assigned_to_user_id CHAR(36) NOT NULL,

    title VARCHAR(255) NOT NULL,
    description TEXT NULL,

    points INT NOT NULL DEFAULT 0,

    due_at DATETIME NULL,

    status ENUM('assigned','submitted','approved','rejected','cancelled') NOT NULL DEFAULT 'assigned',

    submitted_at DATETIME NULL,
    approved_at DATETIME NULL,
    approved_by_user_id CHAR(36) NULL,

    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,

    KEY idx_tasks_family_id (family_id),
    KEY idx_tasks_assigned_by (assigned_by_user_id),
    KEY idx_tasks_assigned_to (assigned_to_user_id),
    KEY idx_tasks_approved_by (approved_by_user_id),
    KEY idx_tasks_status (status),
    KEY idx_tasks_due_at (due_at),

    CONSTRAINT fk_tasks_family
        FOREIGN KEY (family_id) REFERENCES families(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,

    CONSTRAINT fk_tasks_assigned_by
        FOREIGN KEY (assigned_by_user_id) REFERENCES users(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,

    CONSTRAINT fk_tasks_assigned_to
        FOREIGN KEY (assigned_to_user_id) REFERENCES users(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,

    CONSTRAINT fk_tasks_approved_by
        FOREIGN KEY (approved_by_user_id) REFERENCES users(id)
        ON DELETE SET NULL
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE task_proofs (
    id CHAR(36) NOT NULL PRIMARY KEY,
    task_id CHAR(36) NOT NULL,
    user_id CHAR(36) NOT NULL,

    type ENUM('photo','note','link') NOT NULL,
    value TEXT NOT NULL,

    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    KEY idx_task_proofs_task_id (task_id),
    KEY idx_task_proofs_user_id (user_id),

    CONSTRAINT fk_task_proofs_task
        FOREIGN KEY (task_id) REFERENCES tasks(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    CONSTRAINT fk_task_proofs_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE wishes (
    id CHAR(36) NOT NULL PRIMARY KEY,
    family_id CHAR(36) NOT NULL,
    user_id CHAR(36) NOT NULL,

    title VARCHAR(255) NOT NULL,
    description TEXT NULL,

    target_points INT NOT NULL DEFAULT 0,

    status ENUM('active','achieved','redeemed','archived') NOT NULL DEFAULT 'active',

    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,

    KEY idx_wishes_family_id (family_id),
    KEY idx_wishes_user_id (user_id),
    KEY idx_wishes_status (status),

    CONSTRAINT fk_wishes_family
        FOREIGN KEY (family_id) REFERENCES families(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,

    CONSTRAINT fk_wishes_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE points_ledger (
    id CHAR(36) NOT NULL PRIMARY KEY,
    family_id CHAR(36) NOT NULL,
    user_id CHAR(36) NOT NULL,

    source_type ENUM('task','manual','wish_redeem','adjustment') NOT NULL,
    source_id CHAR(36) NULL,

    points INT NOT NULL,

    note TEXT NULL,

    created_by_user_id CHAR(36) NULL,

    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    KEY idx_points_ledger_family_id (family_id),
    KEY idx_points_ledger_user_id (user_id),
    KEY idx_points_ledger_created_by (created_by_user_id),
    KEY idx_points_ledger_source (source_type, source_id),

    CONSTRAINT fk_points_ledger_family
        FOREIGN KEY (family_id) REFERENCES families(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,

    CONSTRAINT fk_points_ledger_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,

    CONSTRAINT fk_points_ledger_created_by
        FOREIGN KEY (created_by_user_id) REFERENCES users(id)
        ON DELETE SET NULL
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE family_invites (
    id CHAR(36) NOT NULL PRIMARY KEY,
    family_id CHAR(36) NOT NULL,

    email VARCHAR(255) NULL,
    role ENUM('parent','child') NOT NULL,

    token VARCHAR(128) NOT NULL,
    expires_at DATETIME NOT NULL,
    used_at DATETIME NULL,

    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    UNIQUE KEY uq_family_invites_token (token),
    KEY idx_family_invites_family_id (family_id),
    KEY idx_family_invites_email (email),

    CONSTRAINT fk_family_invites_family
        FOREIGN KEY (family_id) REFERENCES families(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE user_sessions (
    id CHAR(36) NOT NULL PRIMARY KEY,
    user_id CHAR(36) NOT NULL,

    selector CHAR(24) NOT NULL,
    verifier_hash CHAR(64) NOT NULL,

    expires_at DATETIME NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    last_seen_at DATETIME NULL,

    UNIQUE KEY uq_user_sessions_selector (selector),
    KEY idx_user_sessions_user_id (user_id),
    KEY idx_user_sessions_expires_at (expires_at),

    CONSTRAINT fk_user_sessions_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================
-- Triggers
-- =========================

DELIMITER $$

-- TASKS: family_id must match assigned_by and assigned_to (and approved_by if set)
CREATE TRIGGER trg_tasks_bi_family_check
BEFORE INSERT ON tasks
FOR EACH ROW
BEGIN
    DECLARE v_assigned_by_family CHAR(36);
    DECLARE v_assigned_to_family CHAR(36);
    DECLARE v_approved_by_family CHAR(36);

    SELECT family_id INTO v_assigned_by_family FROM users WHERE id = NEW.assigned_by_user_id LIMIT 1;
    SELECT family_id INTO v_assigned_to_family FROM users WHERE id = NEW.assigned_to_user_id LIMIT 1;

    IF v_assigned_by_family IS NULL OR v_assigned_to_family IS NULL THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Task user does not exist';
    END IF;

    IF NEW.family_id <> v_assigned_by_family OR NEW.family_id <> v_assigned_to_family THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Task family_id must match assigned_by and assigned_to user family_id';
    END IF;

    IF NEW.approved_by_user_id IS NOT NULL THEN
        SELECT family_id INTO v_approved_by_family FROM users WHERE id = NEW.approved_by_user_id LIMIT 1;

        IF v_approved_by_family IS NULL THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Approved by user does not exist';
        END IF;

        IF NEW.family_id <> v_approved_by_family THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Task family_id must match approved_by user family_id';
        END IF;
    END IF;
END$$

CREATE TRIGGER trg_tasks_bu_family_check
BEFORE UPDATE ON tasks
FOR EACH ROW
BEGIN
    DECLARE v_assigned_by_family CHAR(36);
    DECLARE v_assigned_to_family CHAR(36);
    DECLARE v_approved_by_family CHAR(36);

    SELECT family_id INTO v_assigned_by_family FROM users WHERE id = NEW.assigned_by_user_id LIMIT 1;
    SELECT family_id INTO v_assigned_to_family FROM users WHERE id = NEW.assigned_to_user_id LIMIT 1;

    IF v_assigned_by_family IS NULL OR v_assigned_to_family IS NULL THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Task user does not exist';
    END IF;

    IF NEW.family_id <> v_assigned_by_family OR NEW.family_id <> v_assigned_to_family THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Task family_id must match assigned_by and assigned_to user family_id';
    END IF;

    IF NEW.approved_by_user_id IS NOT NULL THEN
        SELECT family_id INTO v_approved_by_family FROM users WHERE id = NEW.approved_by_user_id LIMIT 1;

        IF v_approved_by_family IS NULL THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Approved by user does not exist';
        END IF;

        IF NEW.family_id <> v_approved_by_family THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Task family_id must match approved_by user family_id';
        END IF;
    END IF;
END$$

-- WISHES: family_id must match the owning user family_id
CREATE TRIGGER trg_wishes_bi_family_check
BEFORE INSERT ON wishes
FOR EACH ROW
BEGIN
    DECLARE v_user_family CHAR(36);

    SELECT family_id INTO v_user_family FROM users WHERE id = NEW.user_id LIMIT 1;

    IF v_user_family IS NULL THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Wish owner user does not exist';
    END IF;

    IF NEW.family_id <> v_user_family THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Wish family_id must match user family_id';
    END IF;
END$$

CREATE TRIGGER trg_wishes_bu_family_check
BEFORE UPDATE ON wishes
FOR EACH ROW
BEGIN
    DECLARE v_user_family CHAR(36);

    SELECT family_id INTO v_user_family FROM users WHERE id = NEW.user_id LIMIT 1;

    IF v_user_family IS NULL THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Wish owner user does not exist';
    END IF;

    IF NEW.family_id <> v_user_family THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Wish family_id must match user family_id';
    END IF;
END$$

-- POINTS LEDGER: family_id must match user family_id and created_by family_id if set
CREATE TRIGGER trg_points_ledger_bi_family_check
BEFORE INSERT ON points_ledger
FOR EACH ROW
BEGIN
    DECLARE v_user_family CHAR(36);
    DECLARE v_created_by_family CHAR(36);

    SELECT family_id INTO v_user_family FROM users WHERE id = NEW.user_id LIMIT 1;

    IF v_user_family IS NULL THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Points ledger user does not exist';
    END IF;

    IF NEW.family_id <> v_user_family THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Points ledger family_id must match user family_id';
    END IF;

    IF NEW.created_by_user_id IS NOT NULL THEN
        SELECT family_id INTO v_created_by_family FROM users WHERE id = NEW.created_by_user_id LIMIT 1;

        IF v_created_by_family IS NULL THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Created by user does not exist';
        END IF;

        IF NEW.family_id <> v_created_by_family THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Points ledger family_id must match created_by user family_id';
        END IF;
    END IF;
END$$

CREATE TRIGGER trg_points_ledger_bu_family_check
BEFORE UPDATE ON points_ledger
FOR EACH ROW
BEGIN
    DECLARE v_user_family CHAR(36);
    DECLARE v_created_by_family CHAR(36);

    SELECT family_id INTO v_user_family FROM users WHERE id = NEW.user_id LIMIT 1;

    IF v_user_family IS NULL THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Points ledger user does not exist';
    END IF;

    IF NEW.family_id <> v_user_family THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Points ledger family_id must match user family_id';
    END IF;

    IF NEW.created_by_user_id IS NOT NULL THEN
        SELECT family_id INTO v_created_by_family FROM users WHERE id = NEW.created_by_user_id LIMIT 1;

        IF v_created_by_family IS NULL THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Created by user does not exist';
        END IF;

        IF NEW.family_id <> v_created_by_family THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Points ledger family_id must match created_by user family_id';
        END IF;
    END IF;
END$$

-- TASK PROOFS: proof uploader must be in same family as the task
CREATE TRIGGER trg_task_proofs_bi_family_check
BEFORE INSERT ON task_proofs
FOR EACH ROW
BEGIN
    DECLARE v_task_family CHAR(36);
    DECLARE v_user_family CHAR(36);

    SELECT family_id INTO v_task_family FROM tasks WHERE id = NEW.task_id LIMIT 1;
    SELECT family_id INTO v_user_family FROM users WHERE id = NEW.user_id LIMIT 1;

    IF v_task_family IS NULL THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Task does not exist for proof';
    END IF;

    IF v_user_family IS NULL THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'User does not exist for proof';
    END IF;

    IF v_task_family <> v_user_family THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Task proof user must belong to same family as task';
    END IF;
END$$

CREATE TRIGGER trg_task_proofs_bu_family_check
BEFORE UPDATE ON task_proofs
FOR EACH ROW
BEGIN
    DECLARE v_task_family CHAR(36);
    DECLARE v_user_family CHAR(36);

    SELECT family_id INTO v_task_family FROM tasks WHERE id = NEW.task_id LIMIT 1;
    SELECT family_id INTO v_user_family FROM users WHERE id = NEW.user_id LIMIT 1;

    IF v_task_family IS NULL THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Task does not exist for proof';
    END IF;

    IF v_user_family IS NULL THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'User does not exist for proof';
    END IF;

    IF v_task_family <> v_user_family THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Task proof user must belong to same family as task';
    END IF;
END$$

-- Status integrity triggers for tasks
CREATE TRIGGER trg_tasks_bi_status_integrity
BEFORE INSERT ON tasks
FOR EACH ROW
BEGIN
    IF NEW.status = 'approved' THEN
        IF NEW.approved_by_user_id IS NULL OR NEW.approved_at IS NULL THEN
            SIGNAL SQLSTATE '45000'
                SET MESSAGE_TEXT = 'Approved tasks require approved_by_user_id and approved_at';
        END IF;
    END IF;

    IF NEW.status = 'submitted' THEN
        IF NEW.submitted_at IS NULL THEN
            SIGNAL SQLSTATE '45000'
                SET MESSAGE_TEXT = 'Submitted tasks require submitted_at';
        END IF;
    END IF;

    IF NEW.status = 'rejected' THEN
        IF NEW.approved_by_user_id IS NULL OR NEW.approved_at IS NULL THEN
            SIGNAL SQLSTATE '45000'
                SET MESSAGE_TEXT = 'Rejected tasks require approved_by_user_id and approved_at';
        END IF;
    END IF;

    IF NEW.status = 'cancelled' THEN
        IF NEW.approved_by_user_id IS NOT NULL OR NEW.approved_at IS NOT NULL THEN
            SIGNAL SQLSTATE '45000'
                SET MESSAGE_TEXT = 'Cancelled tasks cannot have approved_by_user_id or approved_at';
        END IF;
    END IF;
END$$

CREATE TRIGGER trg_tasks_bu_status_integrity
BEFORE UPDATE ON tasks
FOR EACH ROW
BEGIN
    IF NEW.status = 'approved' THEN
        IF NEW.approved_by_user_id IS NULL OR NEW.approved_at IS NULL THEN
            SIGNAL SQLSTATE '45000'
                SET MESSAGE_TEXT = 'Approved tasks require approved_by_user_id and approved_at';
        END IF;
    END IF;

    IF NEW.status = 'submitted' THEN
        IF NEW.submitted_at IS NULL THEN
            SIGNAL SQLSTATE '45000'
                SET MESSAGE_TEXT = 'Submitted tasks require submitted_at';
        END IF;
    END IF;

    IF NEW.status = 'rejected' THEN
        IF NEW.approved_by_user_id IS NULL OR NEW.approved_at IS NULL THEN
            SIGNAL SQLSTATE '45000'
                SET MESSAGE_TEXT = 'Rejected tasks require approved_by_user_id and approved_at';
        END IF;
    END IF;

    IF NEW.status = 'cancelled' THEN
        IF NEW.approved_by_user_id IS NOT NULL OR NEW.approved_at IS NOT NULL THEN
            SIGNAL SQLSTATE '45000'
                SET MESSAGE_TEXT = 'Cancelled tasks cannot have approved_by_user_id or approved_at';
        END IF;
    END IF;

    IF NEW.status NOT IN ('approved','rejected') THEN
        IF NEW.approved_by_user_id IS NOT NULL OR NEW.approved_at IS NOT NULL THEN
            SIGNAL SQLSTATE '45000'
                SET MESSAGE_TEXT = 'approved_by_user_id and approved_at can only be set when status is approved or rejected';
        END IF;
    END IF;

    IF NEW.status NOT IN ('submitted','approved','rejected') THEN
        IF NEW.submitted_at IS NOT NULL THEN
            SIGNAL SQLSTATE '45000'
                SET MESSAGE_TEXT = 'submitted_at can only be set when status is submitted, approved, or rejected';
        END IF;
    END IF;
END$$

DELIMITER ;

SET FOREIGN_KEY_CHECKS = 1;
