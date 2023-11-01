USE red_river_climbs;

UPDATE climb_grades
    SET grade_str = '5.10a'

WHERE grade_str = '5.10';

SELECT * FROM climb_grades;