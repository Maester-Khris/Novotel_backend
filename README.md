# new version of Novotel Backend application and API

# Database adapation
- create table commodities
    CREATE TABLE `commodities` (
    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
    `company_id` bigint unsigned DEFAULT NULL,
    `rooms` int NOT NULL,
    `apparts` int NOT NULL,
    `beds` int NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `commodities_company_id_foreign` (`company_id`),
    CONSTRAINT `commodities_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

- SQL procedure for pseudo code
    all_comp_id = select distinct(company_id) from resources;
    foreach cid in all_comp_id:
        total_comp_room = select count(*) from resources where company_id = cid and is_room=true;
        total_comp_appart = select count(*) from resources where company_id = cid and is_appartment=true;
        total_comp_bed = select count(*) from resources where company_id = cid and is_bed=true;
        insert into commodities ('company_id', 'rooms', 'apparts', 'beds') values (cid, total_comp_room, total_comp_appart, total_comp_bed);
        
    DELIMITER //
    CREATE PROCEDURE `populate_commodities`()
    BEGIN
        DECLARE cid INT;
        DECLARE total_comp_room INT;
        DECLARE total_comp_appart INT;
        DECLARE total_comp_bed INT;
        
        DECLARE done INT DEFAULT FALSE;
        DECLARE cur CURSOR FOR SELECT DISTINCT company_id FROM resources;
        DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
        
        OPEN cur;
        read_loop: LOOP
            FETCH cur INTO cid;
            IF done THEN
                LEAVE read_loop;
            END IF;
            
            SELECT COUNT(*) INTO total_comp_room
            FROM resources
            WHERE company_id = cid AND is_room = TRUE;
            
            SELECT COUNT(*) INTO total_comp_appart
            FROM resources
            WHERE company_id = cid AND is_appartment = TRUE;
            
            SELECT COUNT(*) INTO total_comp_bed
            FROM resources
            WHERE company_id = cid AND is_bed = TRUE;
            
            INSERT INTO commodities (company_id, rooms, apparts, beds)
            VALUES (cid, total_comp_room, total_comp_appart, total_comp_bed);
        END LOOP;
        CLOSE cur;
    END//

    DELIMITER ;
    CALL populate_commodities();

- drop * from resources:   
    set foreign_key_checks=0;
    truncate table resources;
    set foreign_key_checks=1;

