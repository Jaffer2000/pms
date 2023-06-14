DELIMITER $$
DROP PROCEDURE IF EXISTS GETAANVRAGEN $$
CREATE PROCEDURE GETAANVRAGEN(IN dateFrom DATE, dateTill DATE, nameRequest VARCHAR(255))
BEGIN
DECLARE actualUserID INT;
SELECT `id` INTO actualUserID FROM `users` WHERE `username` = nameRequest;
SELECT LAST_INSERT_ID() AS generated_id;
INSERT INTO aanvragen (user_id, datum_van, datum_tot, naamaanvraag) VALUES (actualUserID, dateFrom, dateTill, nameRequest);
END$$

CALL GETAANVRAGEN('2023-05-26','2023-05-27','Jaffer');