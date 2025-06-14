-- Desabilitar verificação de chaves estrangeiras temporariamente
SET FOREIGN_KEY_CHECKS = 0;

-- Limpar tabela de serviços realizados
TRUNCATE TABLE services;

-- Limpar tabela de agendamentos
TRUNCATE TABLE appointments;

-- Limpar tabela de raças
TRUNCATE TABLE breeds;

-- Limpar tabela de espécies
TRUNCATE TABLE species;

-- Reabilitar verificação de chaves estrangeiras
SET FOREIGN_KEY_CHECKS = 1; 