PRAGMA foreign_keys = ON;

CREATE TABLE IF NOT EXISTS usuario (
    chave INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    nome TEXT NOT NULL,
    senha TEXT NOT NULL
);

CREATE TABLE tipo_imovel (
  tipo_imovel TEXT PRIMARY KEY NOT NULL
);

INSERT INTO tipo_imovel (tipo_imovel) VALUES 
  ('casa'),
  ('sobrado'),
  ('loja'),
  ('apartamento'),
  ('prédio'),
  ('terreno'),
  ('escritório');

CREATE TABLE situacao_imovel (
  situacao TEXT PRIMARY KEY NOT NULL
);carlao

INSERT INTO situacao_imovel (situacao) VALUES 
  ('alugar'),
  ('vender'),
  ('alugar ou vender'),
  ('alugado'),
  ('vendido'),
  ('cancelado');

CREATE TABLE imovel (
  chave INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  area_construida_m2 INTEGER NOT NULL CHECK(area_construida_m2 >= 0),
  area_total_m2 INTEGER NOT NULL CHECK(area_total_m2 >= 0),
  quartos INTEGER NOT NULL CHECK(quartos >= 0),
  banheiros INTEGER NOT NULL CHECK(banheiros >= 0),
  numero_piso INTEGER,
  logradouro TEXT NOT NULL CHECK(length(logradouro) >= 10 AND length(logradouro) <= 1000),
  preco_venda INTEGER NOT NULL CHECK(preco_venda >= 0),
  mensalidade_aluguel INTEGER NOT NULL CHECK(mensalidade_aluguel >= 0),
  situacao TEXT NOT NULL,
  tipo TEXT NOT NULL,
  FOREIGN KEY (situacao) REFERENCES situacao_imovel (situacao),
  FOREIGN KEY (tipo) REFERENCES tipo_imovel (tipo_imovel)
);
