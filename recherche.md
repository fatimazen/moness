SELECT id, `ess_id`, `latitude`, `longitude`, ( 6371 * acos( cos( radians(48.85296900) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(2.34990300) ) + sin( radians(48.85296900) ) * sin( radians( latitude ) ) ) ) AS distance FROM `geo_localisation_ess` HAVING distance < 50 ORDER BY distance