UPDATE `localidad` SET `Id`=1,`Codigo_Postal`= "3124",`Nombre`="La Plata" WHERE 'Id' = 1

UPDATE `alumno` SET `Id_Localidad`= 1 WHERE 'Id' = 4 OR 'Id' = 5 OR 'Id' = 7 

SELECT a.nombre, l.nombre from alumno as a, localidad as l
where a.Id_Localidad = l.id 

INSERT INTO `materia-alumno`
(`Id_Materia`, `Id_Alumno`, `Cuatrimestre`, `Nota`) 
VALUES 
(2,2,"Primero", 8), 
(3,3,"Primero", 10), 
(1,4,"Segundo", 2), 
(2,5,"Segundo", 5), 
(3,7,"Segundo", 4)


SELECT l.nombre, a.nombre, m.descripcion
from localidad as l, alumno as a, materiaalumno as ma, materia as m
where l.Id = a.Id_Localidad and a.Id = ma.Id_Alumno and ma.Id_Materia = m.Id

SELECT SUM(nota) from materiaalumno

//Nombre y la nota de los alumnos cuyas notas hayan estado entre 4 y 8 
SELECT a.nombre, ma.nota 
FROM alumno as a, materiaalumno as ma 
WHERE a.Id = ma.Id_Alumno and ma.Nota BETWEEN 4 and 8