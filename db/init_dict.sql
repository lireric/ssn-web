INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(1,NULL,1,1,NULL,NULL,
'','Devices types',NULL,1,1);

INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(2,NULL,1,2,NULL,NULL,
'','SSN Commands',NULL,1,1);

INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(3,NULL,1,3,NULL,NULL,
'','Accounts',NULL,1,1);

INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(4,NULL,1,4,NULL,NULL,
'','Value types',NULL,1,1);

INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(9,NULL,1,9,NULL,NULL,
'','Device services',NULL,1,1);

INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(6,NULL,1,6,NULL,NULL,
'','Device statuses',NULL,1,1);

INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(7,NULL,1,7,NULL,NULL,
'','Device states',NULL,1,1);

INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(8,NULL,1,8,NULL,NULL,
'','Event types',NULL,1,1);

-- -------: devices types 
-- parent id = 1  (dict_value_int = 5)

INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(100,1,1,0,NULL,NULL,
'abstract virtual device','VIRTUAL',NULL,1,1);

INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(101,1,1,1,NULL,NULL,
'DS18B20 temperature sensor','temperature sensor',NULL,1,1);

INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(102,1,1,2,NULL,NULL,
'DHT22 humidity and temperature sensor','humidity/temperature sensor',NULL,1,1);

INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(103,1,1,3,NULL,NULL,
'DS1307 RTC device','RTC device',NULL,1,1);

INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(104,1,1,4,NULL,NULL,
'1 pin port IO Push-Pull device (digital out)','digital out (PP)',NULL,1,1);

INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(105,1,1,5,NULL,NULL,
'1 pin port IO Open Drain device','digital out (OD)',NULL,1,1);

INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(106,1,1,6,NULL,NULL,
'1 pin port IO Input device','digital input',NULL,1,1);

INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(107,1,1,7,NULL,NULL,
'1 pin port IO Analogue input device','analogue input',NULL,1,1);

INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(108,1,1,8,NULL,NULL,
'1 pin port IO Analog Output device','analogue output',NULL,1,1);

INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(109,1,1,9,NULL,NULL,
'EEPROM i2c device','EEPROM (i2c)',NULL,1,1);

INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(110,1,1,10,NULL,NULL,
'GSM Modem','GSM Modem',NULL,1,1);

INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(111,1,1,11,NULL,NULL,
'wireless transceiver','wireless',NULL,1,1);


-- -------: devices services 
-- parent id = 9 (dict_value_int = 9)

INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(201,9,1,1,NULL,NULL,
'get state','get state',NULL,1,1);

INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(202,9,1,2,NULL,NULL,
'get status','get status',NULL,1,1);

INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(203,9,1,3,NULL,NULL,
'set status','set status',NULL,1,1);

INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(204,9,1,4,NULL,NULL,
'read property','read property',NULL,1,1);

INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(205,9,1,5,NULL,NULL,
'write property','write property',NULL,1,1);


-- -------: device statuses 
-- parent id = 6 (dict_value_int = 6)

INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(250,6,1,0,NULL,NULL,
'operational','operational',NULL,1,1);

INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(251,6,1,1,NULL,NULL,
'operational manual mode (read only)','manual mode',NULL,1,1);

INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(252,6,1,2,NULL,NULL,
'non operational','non operational',NULL,1,1);


-- -------: device states 
-- parent id = 7 (dict_value_int = 7)

INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(255,7,1,0,NULL,NULL,
'inactive','inactive',NULL,1,1);

INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(256,7,1,1,NULL,NULL,
'active','active',NULL,1,1);


-- -------: Value types 
-- parent id = 4 (dict_value_int = 4)

INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(300,4,1,0,NULL,NULL,
'abstract value','abstract',NULL,1,1);


INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(301,4,1,1,NULL,NULL,
'Degrees-Celsius','Degrees-Celsius',NULL,1,1);

INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(302,4,1,2,NULL,NULL,
'Percent-relative-humidity','humidity (%)',NULL,1,1);


INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(303,4,1,3,NULL,NULL,
'binary value (1/0)','on/off',NULL,1,1);


INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(304,4,1,4,NULL,NULL,
'Volts','Volts',NULL,1,1);


INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(305,4,1,5,NULL,NULL,
'Amperes','Amperes',NULL,1,1);


-- -------: Device types - services 
-- parent id = (100-111) (dict_value_int = <service_code>, dict_value_int3 = 9, dict_value_int2 = p_index)

-- ds18b20 - parent_id = 101:
INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(500,101,1,1,NULL,9,
'get ds18b20 state','get state',NULL,1,1);

INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(501,101,1,2,NULL,9,
'get ds18b20 state','get state',NULL,1,1);

INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(502,101,1,3,NULL,9,
'set ds18b20 status','set status',NULL,1,1);

INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(503,101,1,4,0,9,
'read ds18b20 property','read property',NULL,1,1);
-- value types for read/write properties:
-- dict_value_int = value type, dict_value_float = scale
INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(504,503,1,1,NULL,9,
'read ds18b20 property value type','read property value type',10,1,1);

-- dht22 - parent_id = 102:
INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(510,102,1,1,NULL,9,
'get dht22 state','get state',NULL,1,1);

INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(511,102,1,2,NULL,9,
'get dht22 status','set status',NULL,1,1);

INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(512,102,1,3,NULL,9,
'set dht22 status','set status',NULL,1,1);

INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(513,102,1,4,0,9,
'read dht22 property temperature','read property t',NULL,1,1);
-- value types for read/write properties:
-- dict_value_int = value type, dict_value_float = scale
INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(514,513,1,1,NULL,9,
'read dht22 property value type temperature','read property value type',10,1,1);

INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(515,102,1,4,1,9,
'read dht22 property humidity','read property h',NULL,1,1);
-- value types for read/write properties:
-- dict_value_int = value type, dict_value_float = scale
INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(516,515,1,2,NULL,9,
'read dht22 property value type humidity','read property value type',10,1,1);

-- i/o PP - parent_id = 104:
INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(520,104,1,1,NULL,9,
'get i/o PP state','get state',NULL,1,1);

INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(521,104,1,2,NULL,9,
'get i/o PP status','get status',NULL,1,1);

INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(522,104,1,3,NULL,9,
'set i/o PP status','set status',NULL,1,1);

INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(523,104,1,4,0,9,
'read i/o PP property','read property',NULL,1,1);
-- value types for read/write properties:
-- dict_value_int = value type, dict_value_float = scale
INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(524,523,1,3,NULL,9,
'read i/o PP property value type','read property value type',1,1,1);

INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(525,104,1,5,0,9,
'write i/o PP property','write property',NULL,1,1);
-- value types for read/write properties:
-- dict_value_int = value type, dict_value_float = scale
INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(526,525,1,3,NULL,9,
'write i/o PP property value type','write property value type',1,1,1);

-- i/o OD - parent_id = 105:
INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(530,105,1,1,NULL,9,
'get i/o OD state','get state',NULL,1,1);

INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(531,105,1,2,NULL,9,
'get i/o OD status','get status',NULL,1,1);

INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(532,105,1,3,NULL,9,
'set i/o OD status','set status',NULL,1,1);

INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(533,105,1,4,0,9,
'read i/o OD property','read property',NULL,1,1);
-- value types for read/write properties:
-- dict_value_int = value type, dict_value_float = scale
INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(534,533,1,3,NULL,9,
'read i/o OD property value type','read property value type',-1,1,1);

INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(535,105,1,5,0,9,
'write i/o OD property','write property',NULL,1,1);
-- value types for read/write properties:
-- dict_value_int = value type, dict_value_float = scale
INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(536,535,1,3,NULL,9,
'write i/o OD property value type','write property value type',-1,1,1);

-- i/o digital IN - parent_id = 106:
INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(540,106,1,1,NULL,9,
'get i/o IN state','get state',NULL,1,1);

INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(541,106,1,2,NULL,9,
'get i/o IN status','get status',NULL,1,1);

INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(542,106,1,3,NULL,9,
'set i/o IN status','set status',NULL,1,1);

INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(543,106,1,4,0,9,
'read i/o IN property','read property',NULL,1,1);
-- value types for read/write properties:
-- dict_value_int = value type, dict_value_float = scale
INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(544,543,1,3,NULL,9,
'read i/o IN property value type','read property value type',-1,1,1);


-- -------------------------------------------------------------------------------------------
-- demo data
-- account 1
INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(10000,3,1,1,NULL,NULL,
'Demo account','Demo account',NULL,0,1);

-- account - devices list (dict_value_int = 2)
INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(10001,10000,1,2,NULL,NULL,
'account devices list','account devices',NULL,0,1);

-- account - devices detail (dict_value_int = device_id, dict_value_int2 = dev_index)
-- dict_value_int3 = property_mode, dict_item_comment = dev_comment
-- dict_value_float = scale
-- d(2001):
INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(10002,10001,1,2001,0,0,
'hall temperature','Hall temp.',10,0,1);
-- account - device type (dict_value_int = device type, dict_value_int2 = value type)
INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(10003,10002,1,1,1,NULL,
'2001 device type','2001 dev type',NULL,0,1);

-- d(2100):
INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(10004,10001,1,2100,0,0,
'LED','LED',1,0,1);
-- account - device type (dict_value_int = device type, dict_value_int2 = value type)
INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(10005,10004,1,4,3,NULL,
'2100 device type','2100 dev type',NULL,0,1);

-- account - objects list (dict_value_int = 1)
INSERT INTO ssn_dict
(`id_dict`,`dict_parent`,`dict_item_type`,`dict_value_int`,`dict_value_int2`,`dict_value_int3`,
`dict_item_comment`,`dict_value_string`,`dict_value_float`,`dict_is_common`,`dict_is_active`)
VALUES
(10050,10000,1,1,NULL,NULL,
'account objects list','account objects',NULL,0,1);

