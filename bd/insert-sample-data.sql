-- Inserir espécies
INSERT INTO species (name) VALUES 
('Cachorro'),
('Gato');

-- Inserir raças
INSERT INTO breeds (name, species_id) VALUES 
('Labrador', 1),  -- Labrador para Cachorro
('Poodle', 1),    -- Poodle para Cachorro
('Siamês', 2),    -- Siamês para Gato
('Persa', 2);     -- Persa para Gato

-- Inserir tipos de serviço
INSERT INTO service_types (name, category, default_price, duration_minutes) VALUES
('Consulta Geral', 'consulta', 120.00, 30),
('Hemograma', 'exame', 80.00, 15),
('Raio-X', 'exame', 150.00, 20),
('Castração', 'cirurgia', 350.00, 120); 