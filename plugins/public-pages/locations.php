<?php
/**
 * Export to PHP Array plugin for PHPMyAdmin
 * @author Geoffray Warnants
 * @version 0.2b
 */

//
// Database "locations"
//

// locations.locs
$loc_data = array(
  1 => array( 'id'=>1,'Name'=>'Shed','Marker type'=>'building','Description'=>'Maker Shed','lat'=>37.547050,'long'=>-122.302597,'Altitude (m)'=>-22.200001,'Bearing (deg)'=>170.899994,'Accuracy (m)'=>3,'Speed (m/s)'=>0.75,'Time'=>'2013-05-02 19:01:16','Loc_ID'=>null ),
  2 => array( 'id'=>2,'Name'=>'Seqouia','Marker type'=>'building','Description'=>'','lat'=>37.547363,'long'=>-122.301773,'Altitude (m)'=>-32.400002,'Bearing (deg)'=>0.000000,'Accuracy (m)'=>3,'Speed (m/s)'=>0,'Time'=>'2013-05-02 19:03:14','Loc_ID'=>null ),
  129 => array( 'id'=>3,'Name'=>'Meeting pavilion','Marker type'=>'stage','Description'=>'','lat'=>37.547016,'long'=>-122.301697,'Altitude (m)'=>-28.799999,'Bearing (deg)'=>163.800003,'Accuracy (m)'=>4,'Speed (m/s)'=>1,'Time'=>'2013-05-02 19:04:35','Loc_ID'=>129 ),
  4 => array( 'id'=>4,'Name'=>'Meeting pavilion','Marker type'=>'building','Description'=>'','lat'=>37.546955,'long'=>-122.301765,'Altitude (m)'=>-27.299999,'Bearing (deg)'=>0.000000,'Accuracy (m)'=>3,'Speed (m/s)'=>0,'Time'=>'2013-05-02 19:05:14','Loc_ID'=>null ),
  5 => array( 'id'=>5,'Name'=>'Grass ','Marker type'=>'open','Description'=>'','lat'=>37.547009,'long'=>-122.302162,'Altitude (m)'=>-32.200001,'Bearing (deg)'=>301.600006,'Accuracy (m)'=>3,'Speed (m/s)'=>1.25,'Time'=>'2013-05-02 19:05:55','Loc_ID'=>null ),
  6 => array( 'id'=>6,'Name'=>'Pedal powered Stage','Marker type'=>'stage','Description'=>'','lat'=>37.546604,'long'=>-122.302589,'Altitude (m)'=>-29.600000,'Bearing (deg)'=>267.899994,'Accuracy (m)'=>3,'Speed (m/s)'=>1.5,'Time'=>'2013-05-02 19:07:04','Loc_ID'=>null ),
  7 => array( 'id'=>7,'Name'=>'Arc attack ','Marker type'=>'stage','Description'=>'','lat'=>37.546352,'long'=>-122.302422,'Altitude (m)'=>-21.500000,'Bearing (deg)'=>286.700012,'Accuracy (m)'=>10,'Speed (m/s)'=>0.5,'Time'=>'2013-05-02 19:09:49','Loc_ID'=>null ),
  8 => array( 'id'=>8,'Name'=>'Fiesta Hall','Marker type'=>'building','Description'=>'','lat'=>37.546238,'long'=>-122.302071,'Altitude (m)'=>-18.100000,'Bearing (deg)'=>111.900002,'Accuracy (m)'=>9,'Speed (m/s)'=>0.5,'Time'=>'2013-05-02 19:10:32','Loc_ID'=>null ),
  9 => array( 'id'=>9,'Name'=>'Make:Live','Marker type'=>'stage','Description'=>'','lat'=>37.545380,'long'=>-122.302025,'Altitude (m)'=>-6.100000,'Bearing (deg)'=>135.600006,'Accuracy (m)'=>16,'Speed (m/s)'=>0.5,'Time'=>'2013-05-02 19:13:02','Loc_ID'=>null ),
  10 => array( 'id'=>10,'Name'=>'Meet The Makers','Marker type'=>'stage','Description'=>'','lat'=>37.545444,'long'=>-122.301903,'Altitude (m)'=>-15.300000,'Bearing (deg)'=>131.800003,'Accuracy (m)'=>12,'Speed (m/s)'=>0.5,'Time'=>'2013-05-02 19:13:28','Loc_ID'=>null ),
  11 => array( 'id'=>11,'Name'=>'Make:Electronics','Marker type'=>'','Description'=>'','lat'=>37.545479,'long'=>-122.301849,'Altitude (m)'=>-15.800000,'Bearing (deg)'=>40.500000,'Accuracy (m)'=>12,'Speed (m/s)'=>0.75,'Time'=>'2013-05-02 19:13:48','Loc_ID'=>null ),
  12 => array( 'id'=>12,'Name'=>'Grass A','Marker type'=>'grass','Description'=>'','lat'=>37.545399,'long'=>-122.302917,'Altitude (m)'=>-15.400000,'Bearing (deg)'=>175.600006,'Accuracy (m)'=>4,'Speed (m/s)'=>1.25,'Time'=>'2013-05-02 19:19:45','Loc_ID'=>null ),
  13 => array( 'id'=>13,'Name'=>'Grass B','Marker type'=>'grass','Description'=>'','lat'=>37.545776,'long'=>-122.303268,'Altitude (m)'=>-26.200001,'Bearing (deg)'=>0.000000,'Accuracy (m)'=>3,'Speed (m/s)'=>0,'Time'=>'2013-05-02 19:20:39','Loc_ID'=>null ),
  14 => array( 'id'=>14,'Name'=>'Grass C','Marker type'=>'grass','Description'=>'Maker Camp','lat'=>37.546032,'long'=>-122.303169,'Altitude (m)'=>-30.000000,'Bearing (deg)'=>18.200001,'Accuracy (m)'=>10,'Speed (m/s)'=>0.5,'Time'=>'2013-05-02 19:21:04','Loc_ID'=>null ),
  15 => array( 'id'=>15,'Name'=>'Grass D','Marker type'=>'grass','Description'=>'','lat'=>37.545940,'long'=>-122.303001,'Altitude (m)'=>-29.799999,'Bearing (deg)'=>191.699997,'Accuracy (m)'=>9,'Speed (m/s)'=>1.25,'Time'=>'2013-05-02 19:21:35','Loc_ID'=>null ),
  16 => array( 'id'=>16,'Name'=>'Grass H','Marker type'=>'grass','Description'=>'','lat'=>37.545979,'long'=>-122.302773,'Altitude (m)'=>-29.200001,'Bearing (deg)'=>102.000000,'Accuracy (m)'=>3,'Speed (m/s)'=>1.25,'Time'=>'2013-05-02 19:22:16','Loc_ID'=>null ),
  17 => array( 'id'=>17,'Name'=>'Grass I','Marker type'=>'grass','Description'=>'','lat'=>37.546127,'long'=>-122.302750,'Altitude (m)'=>-29.200001,'Bearing (deg)'=>355.100006,'Accuracy (m)'=>4,'Speed (m/s)'=>1.25,'Time'=>'2013-05-02 19:22:40','Loc_ID'=>null ),
  18 => array( 'id'=>18,'Name'=>'Grass J','Marker type'=>'grass','Description'=>'','lat'=>37.546227,'long'=>-122.302742,'Altitude (m)'=>-29.000000,'Bearing (deg)'=>18.100000,'Accuracy (m)'=>4,'Speed (m/s)'=>1,'Time'=>'2013-05-02 19:23:03','Loc_ID'=>null ),
  19 => array( 'id'=>19,'Name'=>'Grass K','Marker type'=>'grass','Description'=>'','lat'=>37.546379,'long'=>-122.302719,'Altitude (m)'=>-30.900000,'Bearing (deg)'=>0.000000,'Accuracy (m)'=>3,'Speed (m/s)'=>0,'Time'=>'2013-05-02 19:23:46','Loc_ID'=>null ),
  20 => array( 'id'=>20,'Name'=>'Grass G','Marker type'=>'grass','Description'=>'','lat'=>37.546356,'long'=>-122.302910,'Altitude (m)'=>-35.299999,'Bearing (deg)'=>254.399994,'Accuracy (m)'=>4,'Speed (m/s)'=>1.5,'Time'=>'2013-05-02 19:24:01','Loc_ID'=>null ),
  21 => array( 'id'=>21,'Name'=>'Grass E','Marker type'=>'grass','Description'=>'','lat'=>37.546192,'long'=>-122.302986,'Altitude (m)'=>-34.099998,'Bearing (deg)'=>175.399994,'Accuracy (m)'=>3,'Speed (m/s)'=>1.25,'Time'=>'2013-05-02 19:24:30','Loc_ID'=>null ),
  22 => array( 'id'=>22,'Name'=>'Grass F','Marker type'=>'grass','Description'=>'','lat'=>37.546448,'long'=>-122.303352,'Altitude (m)'=>-30.400000,'Bearing (deg)'=>276.299988,'Accuracy (m)'=>4,'Speed (m/s)'=>1.25,'Time'=>'2013-05-02 19:25:17','Loc_ID'=>null ),
  23 => array( 'id'=>23,'Name'=>'Grass M','Marker type'=>'grass','Description'=>'','lat'=>37.546577,'long'=>-122.302521,'Altitude (m)'=>-34.200001,'Bearing (deg)'=>343.100006,'Accuracy (m)'=>4,'Speed (m/s)'=>1.25,'Time'=>'2013-05-02 19:26:37','Loc_ID'=>null ),
  24 => array( 'id'=>24,'Name'=>'Grass N','Marker type'=>'grass','Description'=>'','lat'=>37.546619,'long'=>-122.302261,'Altitude (m)'=>-31.600000,'Bearing (deg)'=>85.500000,'Accuracy (m)'=>5,'Speed (m/s)'=>1.5,'Time'=>'2013-05-02 19:27:13','Loc_ID'=>null ),
  25 => array( 'id'=>25,'Name'=>'Grass O','Marker type'=>'grass','Description'=>'','lat'=>37.546600,'long'=>-122.301804,'Altitude (m)'=>-32.700001,'Bearing (deg)'=>103.900002,'Accuracy (m)'=>4,'Speed (m/s)'=>1.25,'Time'=>'2013-05-02 19:28:01','Loc_ID'=>null ),
  26 => array( 'id'=>26,'Name'=>'Learn To Solder','Marker type'=>'','Description'=>'','lat'=>37.546600,'long'=>-122.301605,'Altitude (m)'=>-31.299999,'Bearing (deg)'=>90.300003,'Accuracy (m)'=>4,'Speed (m/s)'=>1.25,'Time'=>'2013-05-02 19:28:25','Loc_ID'=>null ),
  27 => array( 'id'=>27,'Name'=>'Show Barn','Marker type'=>'building','Description'=>'','lat'=>37.547157,'long'=>-122.301216,'Altitude (m)'=>-29.299999,'Bearing (deg)'=>19.600000,'Accuracy (m)'=>35,'Speed (m/s)'=>0.5,'Time'=>'2013-05-02 19:29:53','Loc_ID'=>null ),
  28 => array( 'id'=>28,'Name'=>'Grass S','Marker type'=>'grass','Description'=>'','lat'=>37.546535,'long'=>-122.301170,'Altitude (m)'=>-27.200001,'Bearing (deg)'=>179.300003,'Accuracy (m)'=>3,'Speed (m/s)'=>1.25,'Time'=>'2013-05-02 19:31:24','Loc_ID'=>null ),
  29 => array( 'id'=>29,'Name'=>'Grass T','Marker type'=>'grass','Description'=>'','lat'=>37.545910,'long'=>-122.301155,'Altitude (m)'=>-26.000000,'Bearing (deg)'=>163.100006,'Accuracy (m)'=>3,'Speed (m/s)'=>1.25,'Time'=>'2013-05-02 19:32:43','Loc_ID'=>null ),
  30 => array( 'id'=>30,'Name'=>'Grass U','Marker type'=>'grass','Description'=>'','lat'=>37.545513,'long'=>-122.301186,'Altitude (m)'=>-18.700001,'Bearing (deg)'=>168.800003,'Accuracy (m)'=>4,'Speed (m/s)'=>1.25,'Time'=>'2013-05-02 19:33:32','Loc_ID'=>null ),
  31 => array( 'id'=>31,'Name'=>'Grass V','Marker type'=>'grass','Description'=>'','lat'=>37.545265,'long'=>-122.301163,'Altitude (m)'=>-19.299999,'Bearing (deg)'=>0.000000,'Accuracy (m)'=>3,'Speed (m/s)'=>0,'Time'=>'2013-05-02 19:34:13','Loc_ID'=>null ),
  32 => array( 'id'=>32,'Name'=>'Model Warships','Marker type'=>'','Description'=>'','lat'=>37.547729,'long'=>-122.303230,'Altitude (m)'=>-31.500000,'Bearing (deg)'=>343.000000,'Accuracy (m)'=>4,'Speed (m/s)'=>0.75,'Time'=>'2013-05-02 19:40:20','Loc_ID'=>null ),
  33 => array( 'id'=>33,'Name'=>'Coke Zero and Mentos','Marker type'=>'stage','Description'=>'','lat'=>37.547733,'long'=>-122.303680,'Altitude (m)'=>-33.000000,'Bearing (deg)'=>273.500000,'Accuracy (m)'=>3,'Speed (m/s)'=>1.25,'Time'=>'2013-05-02 19:41:02','Loc_ID'=>null ),
  34 => array( 'id'=>34,'Name'=>'Baz Biz','Marker type'=>'','Description'=>'','lat'=>37.547729,'long'=>-122.304276,'Altitude (m)'=>-32.099998,'Bearing (deg)'=>269.500000,'Accuracy (m)'=>4,'Speed (m/s)'=>1.25,'Time'=>'2013-05-02 19:41:57','Loc_ID'=>null ),
  35 => array( 'id'=>35,'Name'=>'Mousetrap','Marker type'=>'','Description'=>'','lat'=>37.547283,'long'=>-122.303345,'Altitude (m)'=>-30.500000,'Bearing (deg)'=>118.699997,'Accuracy (m)'=>4,'Speed (m/s)'=>1.25,'Time'=>'2013-05-02 19:43:28','Loc_ID'=>null)
);
