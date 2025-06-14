-- Criar banco de dados
CREATE DATABASE vet_clinic CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE vet_clinic;

-- 1. Tabela de Tutores
CREATE TABLE tutors (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    cpf VARCHAR(14) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20) NOT NULL,
    whatsapp VARCHAR(20),
    address VARCHAR(255),
    city VARCHAR(100),
    state CHAR(2),
    zip_code VARCHAR(10),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_name (name),
    INDEX idx_cpf (cpf)
) ENGINE=InnoDB;

-- 2. Tabela de Espécies
CREATE TABLE species (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 3. Tabela de Raças
CREATE TABLE breeds (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    species_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (species_id) REFERENCES species(id) ON DELETE CASCADE,
    INDEX idx_species (species_id)
) ENGINE=InnoDB;

-- 4. Tabela de Animais
CREATE TABLE animals (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    species_id BIGINT UNSIGNED NOT NULL,
    breed_id BIGINT UNSIGNED,
    tutor_id BIGINT UNSIGNED NOT NULL,
    birth_date DATE,
    gender ENUM('M', 'F') NOT NULL,
    weight DECIMAL(6,2),
    observations TEXT,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (species_id) REFERENCES species(id),
    FOREIGN KEY (breed_id) REFERENCES breeds(id) ON DELETE SET NULL,
    FOREIGN KEY (tutor_id) REFERENCES tutors(id) ON DELETE CASCADE,
    INDEX idx_tutor (tutor_id),
    INDEX idx_name (name)
) ENGINE=InnoDB;

-- 5. Tabela de Tipos de Serviço
CREATE TABLE service_types (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    category ENUM('consulta', 'exame', 'cirurgia', 'vacina', 'outros') NOT NULL,
    default_price DECIMAL(10,2),
    duration_minutes INT DEFAULT 30,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_category (category)
) ENGINE=InnoDB;

-- 6. Tabela de Agendamentos
CREATE TABLE appointments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    animal_id BIGINT UNSIGNED NOT NULL,
    service_type_id BIGINT UNSIGNED NOT NULL,
    scheduled_date DATE NOT NULL,
    scheduled_time TIME NOT NULL,
    status ENUM('agendado', 'confirmado', 'em_atendimento', 'concluido', 'cancelado') DEFAULT 'agendado',
    observations TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (animal_id) REFERENCES animals(id),
    FOREIGN KEY (service_type_id) REFERENCES service_types(id),
    INDEX idx_date (scheduled_date),
    INDEX idx_animal (animal_id),
    INDEX idx_status (status)
) ENGINE=InnoDB;

-- 7. Tabela de Serviços Realizados
CREATE TABLE services (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    animal_id BIGINT UNSIGNED NOT NULL,
    service_type_id BIGINT UNSIGNED NOT NULL,
    appointment_id BIGINT UNSIGNED,
    service_date DATE NOT NULL,
    description TEXT NOT NULL,
    observations TEXT,
    price DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (animal_id) REFERENCES animals(id),
    FOREIGN KEY (service_type_id) REFERENCES service_types(id),
    FOREIGN KEY (appointment_id) REFERENCES appointments(id) ON DELETE SET NULL,
    INDEX idx_animal_date (animal_id, service_date)
) ENGINE=InnoDB;

-- 8. Inserir dados iniciais
INSERT INTO species (name) VALUES 
('Cachorro'), ('Gato');

INSERT INTO breeds (name, species_id) VALUES 
('Vira-lata', 1), ('Labrador', 1), ('Poodle', 1),
('Siamês', 2), ('Persa', 2), ('Vira-lata', 2);

INSERT INTO services (name, category, default_price) VALUES
('Consulta Geral', 'consulta', 120.00),
('Hemograma', 'exame', 80.00),
('Raio-X', 'exame', 150.00),
('Castração', 'cirurgia', 350.00),
('Vacina V10', 'vacina', 90.00);