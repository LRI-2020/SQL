-- Affiche toutes les données.

SELECT *
from school
    join students
        on school.idschool=students.school;
-- Affiche uniquement les prénoms
SELECT prenom from students;

-- Affiche les prénoms, les dates de naissance et l’école de chacun.
SELECT prenom, datenaissance as 'date de naissance', school.school
from school join students on school.idschool=students.school;

-- Affiche uniquement les élèves qui sont de sexe féminin.
SELECT * from students where genre='F';

-- Affiche uniquement les élèves qui font partie de l’école d'Addy.
SELECT * from students where school = (SELECT school from students where nom = 'addy');

-- Affiche uniquement les prénoms des étudiants, par ordre inverse à l’alphabet (DESC). Ensuite, la même chose mais en limitant les résultats à 2.
SELECT prenom from students order by nom desc;
SELECT prenom from students order by nom desc limit 2;

-- Ajoute Ginette Dalor, née le 01/01/1930 et affecte-la à Bruxelles, toujours en SQL.

INSERT INTO students (datenaissance,genre,nom,prenom,school)
VALUES('1930-01-01','F','Dolor','Ginette',1);

-- Modifie Ginette (toujours en SQL) et change son sexe et son prénom en “Omer”.

UPDATE students
SET prenom = 'Omer', genre='M'
WHERE idStudent = 31;

-- Supprimer la personne dont l’ID est 3.
    DELETE FROM students
    WHERE idStudent = 3;

-- Modifier le contenu de la colonne School de sorte que "1" soit remplacé par "Liege" et "2" soit remplacé par "Gent". (attention au type de la colonne !)

UPDATE school
SET school = 'Liege'
WHERE idSchool = 1;

UPDATE school
SET school = 'Gent'
WHERE idSchool = 2;
