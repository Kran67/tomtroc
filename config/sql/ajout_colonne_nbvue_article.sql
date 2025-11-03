ALTER TABLE article ADD COLUMN views_count INT DEFAULT 0 NOT NULL AFTER content;

-- Mettre à jour les articles existants avec une valeur par défaut
UPDATE article SET views_count = 0 WHERE views_count IS NULL;