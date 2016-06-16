# Identify: MjAxNS0wOC0xMyAwOTozMDozNCwxLjAsYWxsLG11bHRpdm9sLDE=
# <?exit();?>
# NewsRoom Multi-Volume Data Dump Vol.1
# Version: cmradio 1.0
# Time: 2015-08-13 09:30:34
# Type: all
# Table Prefix: fm_
#
# NewsRoom: http://www.NewsRoom.com
# Please visit our website for newest infomation about cmradio
# ---------------------------------------------------------


--
-- 表的结构fm_admin
--

DROP TABLE IF EXISTS `fm_admin`;
CREATE TABLE `fm_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(11) NOT NULL DEFAULT '0',
  `username` varchar(100) NOT NULL DEFAULT '',
  `password` varchar(100) NOT NULL DEFAULT '',
  `truename` varchar(100) NOT NULL DEFAULT '',
  `telephone` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `remarks` varchar(100) NOT NULL DEFAULT '',
  `addtime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COMMENT='后台管理员表';

--
-- 转存表中的数据 fm_admin
--

INSERT INTO `fm_admin` VALUES('1','1','tangjian','34cdf1a3da6eaa23ff3c4788191db355','唐工','111111111','','呵呵','0');
INSERT INTO `fm_admin` VALUES('8','1','jaqy','23ac70788a178d55639013793bae4114','小强','','','','1394074604');
INSERT INTO `fm_admin` VALUES('6','1','admin1003','708a1e1c380562c8b6b7f78bfe49167b','交通台','','','1003','1385604910');
INSERT INTO `fm_admin` VALUES('7','2','fm1003','708a1e1c380562c8b6b7f78bfe49167b','交通台','','','','1389876753');
INSERT INTO `fm_admin` VALUES('9','2','wx1003','5749a1cb9edbc2a99d4df611c4f91258','微信1003','','','发布微信信息','1395115135');
INSERT INTO `fm_admin` VALUES('10','2','news','ca12c423007e13830c7fa9666c78e803','新闻管理员','','','','1395898687');
INSERT INTO `fm_admin` VALUES('21','1','bbrtv','f12ae47e9eae9ff8bbc387813244c1bd','北部湾在线','','bbrtv@bbrtv.com','','1415764250');
INSERT INTO `fm_admin` VALUES('12','2','小微','4fee684525b244e636e2e3ee39ef693a','','','','','1400203567');
INSERT INTO `fm_admin` VALUES('20','1','莫晓山','6f18fff9e9656735b4311db198b5094d','莫晓山','18607815193','6778469@qq.com','','1415763888');
INSERT INTO `fm_admin` VALUES('16','1','lyz','a65a0c97842a20e26d67eed4173d0c6a','吕工','','','','1414459476');
INSERT INTO `fm_admin` VALUES('22','1','hxz','b45a332c9d11a7a9218add11c536899f','黄显朝','','','','1417060789');
INSERT INTO `fm_admin` VALUES('19','2','刘艾','9bad2764044171acdab696d32fb4c16d','刘艾丽丝','','','','1415698488');
INSERT INTO `fm_admin` VALUES('23','1','wyb','a5f8f94f064f1165cf5cdbc3ae7d4d3d','wyb','1','1','1','1418718256');
INSERT INTO `fm_admin` VALUES('24','1','lkl','2a0e6a8a3599c10631652f11d15f91d4','刘柯良','','','','1435712319');
INSERT INTO `fm_admin` VALUES('25','1','ldy','9bad2764044171acdab696d32fb4c16d','','','','','1436253240');
INSERT INTO `fm_admin` VALUES('26','1','jhz','9bad2764044171acdab696d32fb4c16d','蒋洪振','','','','1437360107');
--
-- 表的结构fm_adminlog
--

DROP TABLE IF EXISTS `fm_adminlog`;
CREATE TABLE `fm_adminlog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `adminid` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(200) NOT NULL DEFAULT '',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `browser` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23485 DEFAULT CHARSET=utf8 COMMENT='后台操作日志';

--
-- 转存表中的数据 fm_adminlog
--

INSERT INTO `fm_adminlog` VALUES('23284','23','登录成功','192.168.6.168','1435284225','Firefox38.0');
INSERT INTO `fm_adminlog` VALUES('23285','23','登录成功','192.168.6.168','1435302065','Firefox38.0');
INSERT INTO `fm_adminlog` VALUES('23286','23','登录成功','192.168.6.168','1435540425','Firefox38.0');
INSERT INTO `fm_adminlog` VALUES('23287','23','登录成功','127.0.0.1','1435712292','Firefox38.0');
INSERT INTO `fm_adminlog` VALUES('23321','23','修改信息:comment->1','192.168.6.168','1437446099','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23290','24','登录成功','127.0.0.1','1435712334','Firefox38.0');
INSERT INTO `fm_adminlog` VALUES('23291','24','删除信息channel1','127.0.0.1','1435734608','Firefox38.0');
INSERT INTO `fm_adminlog` VALUES('23292','24','删除信息channel3','127.0.0.1','1435737647','Firefox38.0');
INSERT INTO `fm_adminlog` VALUES('23293','24','登录成功','127.0.0.1','1435801775','Firefox38.0');
INSERT INTO `fm_adminlog` VALUES('23294','24','登录成功','127.0.0.1','1435831156','Mozilla5.0');
INSERT INTO `fm_adminlog` VALUES('23295','24','登录成功','127.0.0.1','1435884800','Firefox38.0');
INSERT INTO `fm_adminlog` VALUES('23296','24','删除信息program_type2','127.0.0.1','1435890713','Firefox38.0');
INSERT INTO `fm_adminlog` VALUES('23297','24','登录成功','127.0.0.1','1436143579','Firefox38.0');
INSERT INTO `fm_adminlog` VALUES('23298','24','登录成功','127.0.0.1','1436147879','Firefox38.0');
INSERT INTO `fm_adminlog` VALUES('23299','24','登录成功','127.0.0.1','1436229446','Firefox38.0');
INSERT INTO `fm_adminlog` VALUES('23300','23','登录成功','127.0.0.1','1436231727','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23301','24','删除信息program3','127.0.0.1','1436235043','Firefox38.0');
INSERT INTO `fm_adminlog` VALUES('23302','24','登录成功','127.0.0.1','1436252044','Firefox38.0');
INSERT INTO `fm_adminlog` VALUES('23303','23','登录成功','127.0.0.1','1436252952','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23304','24','登录成功','127.0.0.1','1436315219','Firefox38.0');
INSERT INTO `fm_adminlog` VALUES('23305','23','登录成功','192.168.6.168','1436433032','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23306','8','登录成功','192.168.6.189','1436515745','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23307','23','登录成功','192.168.6.168','1436518077','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23308','23','登录成功','192.168.6.168','1436598201','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23309','23','登录成功','192.168.6.168','1436688304','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23310','23','登录成功','192.168.6.168','1436755890','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23311','24','登录成功','127.0.0.1','1436760878','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23312','23','登录成功','192.168.6.168','1436840290','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23313','23','登录成功','192.168.6.168','1437359926','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23314','26','登录成功','171.107.29.93','1437360202','Chrome43.0.2357.132');
INSERT INTO `fm_adminlog` VALUES('23315','23','登录成功','192.168.6.168','1437376739','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23316','23','登录成功','192.168.6.168','1437440693','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23317','8','登录成功','192.168.6.189','1437440956','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23318','23','登录成功','192.168.6.168','1437442498','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23319','25','登录成功','127.0.0.1','1437443217','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23320','23','修改信息comment1','192.168.6.168','1437444181','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23322','23','修改信息: comment -> 1','192.168.6.168','1437446170','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23323','25','修改信息: comment -> 1','127.0.0.1','1437446495','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23324','25','删除信息: comment -> 1','127.0.0.1','1437446563','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23325','25','修改信息: comment -> 1','127.0.0.1','1437447158','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23326','25','修改信息: admin -> 25','127.0.0.1','1437447770','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23327','25','修改信息: program -> 4','127.0.0.1','1437448495','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23328','25','登录成功','127.0.0.1','1437467032','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23329','25','修改信息: admin -> 26','127.0.0.1','1437467573','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23330','25','添加信息: member -> 432','127.0.0.1','1437467889','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23331','25','修改信息: member -> 432','127.0.0.1','1437467909','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23332','25','删除信息: member -> 432','127.0.0.1','1437467926','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23333','23','登录成功','192.168.6.168','1437527503','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23334','25','登录成功','127.0.0.1','1437530674','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23335','25','添加信息: member -> 433','127.0.0.1','1437548057','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23336','25','添加信息: member -> 434','127.0.0.1','1437548153','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23337','25','添加信息: member -> 435','127.0.0.1','1437548273','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23338','25','添加信息: member -> 436','127.0.0.1','1437548338','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23339','25','添加信息: member -> 437','127.0.0.1','1437548396','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23340','25','添加信息: member -> 438','127.0.0.1','1437548431','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23341','25','添加信息: member -> 439','127.0.0.1','1437548469','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23342','25','添加信息: member -> 440','127.0.0.1','1437548516','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23343','25','添加信息: member -> 441','127.0.0.1','1437548560','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23344','25','添加信息: member -> 442','127.0.0.1','1437548610','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23345','25','添加信息: member -> 443','127.0.0.1','1437548639','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23346','25','添加信息: member -> 444','127.0.0.1','1437548686','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23347','25','添加信息: program_type -> 6','127.0.0.1','1437548859','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23348','25','添加信息: program_type -> 7','127.0.0.1','1437548902','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23349','25','添加信息: program_type -> 8','127.0.0.1','1437548920','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23350','25','添加信息: program_type -> 9','127.0.0.1','1437548942','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23351','25','添加信息: program_type -> 10','127.0.0.1','1437548961','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23352','25','添加信息: program_type -> 11','127.0.0.1','1437548975','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23353','25','添加信息: program_type -> 12','127.0.0.1','1437548988','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23354','25','添加信息: program_type -> 13','127.0.0.1','1437549001','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23355','25','添加信息: program_type -> 14','127.0.0.1','1437549009','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23356','25','修改信息: program_type -> 7','127.0.0.1','1437549030','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23357','25','添加信息: program_type -> 15','127.0.0.1','1437549045','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23358','25','添加信息: program_type -> 16','127.0.0.1','1437549071','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23359','25','添加信息: program_type -> 17','127.0.0.1','1437549099','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23360','25','登录成功','192.168.6.119','1437552949','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23361','26','登录成功','171.107.29.93','1437553268','Chrome43.0.2357.132');
INSERT INTO `fm_adminlog` VALUES('23362','26','登录成功','222.216.31.36','1437553478','Chrome43.0.2357.132');
INSERT INTO `fm_adminlog` VALUES('23363','26','登录成功','171.107.29.93','1437553787','Chrome43.0.2357.132');
INSERT INTO `fm_adminlog` VALUES('23364','24','登录成功','127.0.0.1','1437560013','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23365','24','登录成功','127.0.0.1','1437611910','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23366','25','登录成功','192.168.6.119','1437612471','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23367','8','登录成功','192.168.6.189','1437613990','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23368','23','登录成功','192.168.6.168','1437614482','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23369','24','添加信息: programme -> 1','127.0.0.1','1437615310','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23370','25','登录成功','127.0.0.1','1437617587','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23371','24','修改信息: programme -> 1','127.0.0.1','1437621367','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23372','24','修改信息: programme -> 1','127.0.0.1','1437621435','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23373','24','修改信息: programme -> 1','127.0.0.1','1437622808','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23374','24','登录成功','127.0.0.1','1437633962','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23375','24','添加信息: member -> 445','127.0.0.1','1437640556','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23376','24','修改信息: programme -> 1','127.0.0.1','1437640611','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23377','24','登录成功','127.0.0.1','1437698446','Chrome39.0.2171.95');
INSERT INTO `fm_adminlog` VALUES('23378','24','登录成功','127.0.0.1','1437705940','Chrome39.0.2171.95');
INSERT INTO `fm_adminlog` VALUES('23379','24','登录成功','127.0.0.1','1437705947','Chrome39.0.2171.95');
INSERT INTO `fm_adminlog` VALUES('23380','24','登录成功','127.0.0.1','1437724562','Chrome39.0.2171.95');
INSERT INTO `fm_adminlog` VALUES('23381','24','修改信息: programme -> 1','127.0.0.1','1437724603','Chrome39.0.2171.95');
INSERT INTO `fm_adminlog` VALUES('23382','26','登录成功','171.107.29.93','1437725085','Chrome43.0.2357.132');
INSERT INTO `fm_adminlog` VALUES('23383','24','登录成功','127.0.0.1','1437957942','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23384','8','登录成功','192.168.6.189','1437959425','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23385','24','登录成功','127.0.0.1','1437965587','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23386','24','登录成功','127.0.0.1','1437968072','Chrome39.0.2171.95');
INSERT INTO `fm_adminlog` VALUES('23387','24','登录成功','127.0.0.1','1437989004','Chrome39.0.2171.95');
INSERT INTO `fm_adminlog` VALUES('23388','24','登录成功','127.0.0.1','1438045178','Chrome39.0.2171.95');
INSERT INTO `fm_adminlog` VALUES('23389','26','登录成功','113.12.247.137','1438048229','Chrome43.0.2357.132');
INSERT INTO `fm_adminlog` VALUES('23390','26','登录成功','218.65.215.178','1438048259','Chrome43.0.2357.132');
INSERT INTO `fm_adminlog` VALUES('23391','26','登录成功','113.12.247.137','1438048277','Chrome43.0.2357.132');
INSERT INTO `fm_adminlog` VALUES('23392','24','登录成功','127.0.0.1','1438130926','Chrome39.0.2171.95');
INSERT INTO `fm_adminlog` VALUES('23393','8','登录成功','192.168.6.189','1438132667','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23394','24','添加信息: member -> 446','127.0.0.1','1438139608','Chrome39.0.2171.95');
INSERT INTO `fm_adminlog` VALUES('23395','24','登录成功','127.0.0.1','1438216556','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23396','24','登录成功','127.0.0.1','1438216814','Chrome39.0.2171.95');
INSERT INTO `fm_adminlog` VALUES('23397','24','登录成功','127.0.0.1','1438217160','Mozilla5.0');
INSERT INTO `fm_adminlog` VALUES('23398','8','登录成功','192.168.6.189','1438218530','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23399','23','登录成功','192.168.6.168','1438221832','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23400','25','登录成功','127.0.0.1','1438242649','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23401','8','修改信息: comment -> 1','192.168.6.189','1438244339','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23402','0','退出登录','192.168.6.189','1438246265','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23403','8','登录成功','192.168.6.189','1438246315','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23404','25','登录成功','127.0.0.1','1438303859','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23405','24','登录成功','127.0.0.1','1438303997','Chrome39.0.2171.95');
INSERT INTO `fm_adminlog` VALUES('23406','8','登录成功','192.168.6.189','1438309633','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23407','24','登录成功','127.0.0.1','1438561606','Chrome39.0.2171.95');
INSERT INTO `fm_adminlog` VALUES('23408','25','登录成功','127.0.0.1','1438590650','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23409','24','登录成功','127.0.0.1','1438648622','Chrome39.0.2171.95');
INSERT INTO `fm_adminlog` VALUES('23410','25','登录成功','127.0.0.1','1438649666','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23411','25','登录成功','127.0.0.1','1438650980','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23412','25','添加信息: program_type -> 19','127.0.0.1','1438654152','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23413','25','登录成功','192.168.6.119','1438657700','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23414','24','修改信息: programme -> 1','127.0.0.1','1438658086','Chrome39.0.2171.95');
INSERT INTO `fm_adminlog` VALUES('23415','24','登录成功','127.0.0.1','1438659397','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23416','25','登录成功','127.0.0.1','1438673036','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23417','25','添加信息: program -> 16','127.0.0.1','1438678961','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23418','24','登录成功','127.0.0.1','1438735663','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23419','25','登录成功','127.0.0.1','1438735943','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23420','24','添加信息: program -> 17','127.0.0.1','1438741190','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23421','24','修改信息: program -> 17','127.0.0.1','1438741235','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23422','25','添加信息: program -> 19','127.0.0.1','1438742213','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23423','25','登录成功','192.168.6.119','1438742368','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23424','25','删除信息: program -> 18','192.168.6.119','1438742385','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23425','24','登录成功','127.0.0.1','1438745557','Chrome39.0.2171.95');
INSERT INTO `fm_adminlog` VALUES('23426','24','修改信息: program -> 17','127.0.0.1','1438746292','Chrome39.0.2171.95');
INSERT INTO `fm_adminlog` VALUES('23427','24','修改信息: program -> 17','127.0.0.1','1438746385','Chrome39.0.2171.95');
INSERT INTO `fm_adminlog` VALUES('23428','25','修改信息: member -> 448','192.168.6.119','1438764879','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23429','25','登录成功','127.0.0.1','1438767468','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23430','24','登录成功','127.0.0.1','1438821952','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23431','25','登录成功','127.0.0.1','1438822897','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23432','23','登录成功','192.168.6.168','1438823867','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23433','23','登录成功','192.168.6.168','1438823921','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23434','25','登录成功','192.168.6.119','1438824446','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23435','25','修改信息: program -> 19','192.168.6.119','1438824565','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23436','25','修改信息: program -> 17','192.168.6.119','1438824628','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23437','25','修改信息: program -> 16','192.168.6.119','1438824689','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23438','25','修改信息: program -> 15','192.168.6.119','1438824802','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23439','25','修改信息: program -> 14','192.168.6.119','1438824825','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23440','25','修改信息: program -> 13','192.168.6.119','1438824847','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23441','25','修改信息: program -> 12','192.168.6.119','1438824869','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23442','25','修改信息: program -> 4','192.168.6.119','1438824887','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23443','23','添加信息: program_type -> 20','192.168.6.168','1438825035','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23444','25','修改信息: program -> 11','127.0.0.1','1438826899','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23445','25','修改信息: program -> 13','192.168.6.119','1438827089','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23446','23','修改信息: program -> 5','192.168.6.168','1438827343','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23447','24','登录成功','127.0.0.1','1438847243','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23448','25','登录成功','192.168.6.119','1438848202','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23449','25','删除信息: channel -> 7','192.168.6.119','1438848986','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23450','25','添加信息: program_type -> 21','127.0.0.1','1438855727','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23451','25','添加信息: program_type -> 22','127.0.0.1','1438855796','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23452','25','添加信息: program_type -> 23','127.0.0.1','1438855807','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23453','25','删除信息: program_type -> 23','127.0.0.1','1438855815','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23454','25','登录成功','127.0.0.1','1438909172','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23455','23','登录成功','192.168.6.168','1438909664','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23456','25','登录成功','192.168.6.119','1438914046','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23457','23','登录成功','192.168.6.168','1438933455','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23458','23','修改信息: member -> 430','192.168.6.168','1438933531','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23459','24','修改信息: member -> 445','127.0.0.1','1438934225','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23460','25','登录成功','192.168.6.119','1438935453','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23461','24','登录成功','127.0.0.1','1438936078','Chrome39.0.2171.95');
INSERT INTO `fm_adminlog` VALUES('23462','24','修改信息: member -> 445','127.0.0.1','1438937692','Chrome39.0.2171.95');
INSERT INTO `fm_adminlog` VALUES('23463','24','修改信息: member -> 448','127.0.0.1','1438937779','Chrome39.0.2171.95');
INSERT INTO `fm_adminlog` VALUES('23464','24','修改信息: member -> 441','127.0.0.1','1438937838','Chrome39.0.2171.95');
INSERT INTO `fm_adminlog` VALUES('23465','24','修改信息: member -> 439','127.0.0.1','1438937855','Chrome39.0.2171.95');
INSERT INTO `fm_adminlog` VALUES('23466','24','修改信息: member -> 437','127.0.0.1','1438937892','Chrome39.0.2171.95');
INSERT INTO `fm_adminlog` VALUES('23467','24','登录成功','127.0.0.1','1439167794','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23468','25','登录成功','127.0.0.1','1439168246','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23469','24','登录成功','127.0.0.1','1439191703','Chrome39.0.2171.95');
INSERT INTO `fm_adminlog` VALUES('23470','23','登录成功','192.168.6.168','1439195582','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23471','24','登录成功','127.0.0.1','1439253901','Chrome39.0.2171.95');
INSERT INTO `fm_adminlog` VALUES('23472','23','登录成功','192.168.6.168','1439259817','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23473','25','登录成功','192.168.6.119','1439264820','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23474','25','添加信息: program -> 20','192.168.6.119','1439264907','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23475','25','登录成功','127.0.0.1','1439276649','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23476','23','登录成功','192.168.6.168','1439278533','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23477','23','登录成功','192.168.6.168','1439278575','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23478','24','登录成功','127.0.0.1','1439285093','Chrome39.0.2171.95');
INSERT INTO `fm_adminlog` VALUES('23479','23','登录成功','192.168.6.168','1439340377','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23480','24','登录成功','127.0.0.1','1439340612','Chrome39.0.2171.95');
INSERT INTO `fm_adminlog` VALUES('23481','24','登录成功','127.0.0.1','1439363065','Chrome39.0.2171.95');
INSERT INTO `fm_adminlog` VALUES('23482','24','登录成功','127.0.0.1','1439426985','Chrome39.0.2171.95');
INSERT INTO `fm_adminlog` VALUES('23483','23','登录成功','192.168.6.168','1439427692','Firefox39.0');
INSERT INTO `fm_adminlog` VALUES('23484','23','登录成功','192.168.6.168','1439429155','Firefox40.0');
--
-- 表的结构fm_attention
--

DROP TABLE IF EXISTS `fm_attention`;
CREATE TABLE `fm_attention` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '数据id',
  `mid` int(11) NOT NULL COMMENT '关注者id',
  `zid` int(11) NOT NULL COMMENT '被关注者id',
  `addtime` int(12) DEFAULT NULL,
  `is_zcr` int(1) DEFAULT '0' COMMENT '被关注者是否为主持人',
  PRIMARY KEY (`id`,`mid`,`zid`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 fm_attention
--

INSERT INTO `fm_attention` VALUES('4','1','4','1438916611','0');
INSERT INTO `fm_attention` VALUES('6','2','4','1438917479','0');
INSERT INTO `fm_attention` VALUES('7','3','4','1438920050','0');
INSERT INTO `fm_attention` VALUES('9','431','433','1438920191','1');
INSERT INTO `fm_attention` VALUES('10','3','56','1438922795','0');
INSERT INTO `fm_attention` VALUES('11','445','433','1438932045','1');
--
-- 表的结构fm_bad_word
--

DROP TABLE IF EXISTS `fm_bad_word`;
CREATE TABLE `fm_bad_word` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `type` smallint(6) NOT NULL DEFAULT '1',
  `find` varchar(255) NOT NULL DEFAULT '',
  `replacement` varchar(255) NOT NULL DEFAULT '',
  `extra` varchar(255) NOT NULL DEFAULT '',
  `addtime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 fm_bad_word
--

INSERT INTO `fm_bad_word` VALUES('5','1','你妹','***','','1421723661');
--
-- 表的结构fm_channel
--

DROP TABLE IF EXISTS `fm_channel`;
CREATE TABLE `fm_channel` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '频道名称',
  `description` varchar(100) NOT NULL DEFAULT '' COMMENT '频道简介',
  `status` int(1) NOT NULL DEFAULT '0',
  `sort` int(10) NOT NULL DEFAULT '0',
  `addtime` int(11) NOT NULL DEFAULT '0',
  `mid` int(10) NOT NULL DEFAULT '0' COMMENT '会员id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 fm_channel
--

INSERT INTO `fm_channel` VALUES('4','小小鱼','小小鱼测试频道','0','3','1435889042','430');
INSERT INTO `fm_channel` VALUES('2','测试频道','测试频道','0','6','1435735449','430');
INSERT INTO `fm_channel` VALUES('5','新闻','','0','0','1438848478','448');
INSERT INTO `fm_channel` VALUES('6','新闻','','0','0','1438848482','448');
--
-- 表的结构fm_feedback
--

DROP TABLE IF EXISTS `fm_feedback`;
CREATE TABLE `fm_feedback` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `content` varchar(256) NOT NULL DEFAULT '',
  `audio` varchar(100) NOT NULL DEFAULT '',
  `audio_time` smallint(5) NOT NULL DEFAULT '0' COMMENT '音频时长',
  `mid` int(10) NOT NULL DEFAULT '0',
  `addtime` int(11) NOT NULL DEFAULT '0',
  `isread` int(1) NOT NULL DEFAULT '0' COMMENT '是否已读',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 fm_feedback
--

INSERT INTO `fm_feedback` VALUES('2','这个怎么用','','0','431','1436695503','0');
--
-- 表的结构fm_ios_crash
--

DROP TABLE IF EXISTS `fm_ios_crash`;
CREATE TABLE `fm_ios_crash` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `success` tinyint(1) NOT NULL,
  `on` tinyint(1) NOT NULL,
  `version` varchar(10) NOT NULL,
  `build` varchar(10) NOT NULL,
  `addtime` int(12) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 fm_ios_crash
--

INSERT INTO `fm_ios_crash` VALUES('2','1','1','1.4','1.4','1427426563');
--
-- 表的结构fm_member
--

DROP TABLE IF EXISTS `fm_member`;
CREATE TABLE `fm_member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(11) NOT NULL DEFAULT '0' COMMENT '用户组id',
  `username` varchar(100) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(100) NOT NULL DEFAULT '' COMMENT '密码',
  `nickname` varchar(50) NOT NULL DEFAULT '' COMMENT '昵称',
  `truename` varchar(100) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `gender` tinyint(4) NOT NULL DEFAULT '0' COMMENT '性别',
  `email` varchar(100) NOT NULL DEFAULT '' COMMENT '邮箱',
  `tel` varchar(100) NOT NULL DEFAULT '' COMMENT '电话',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '地址',
  `sign` varchar(255) NOT NULL DEFAULT '' COMMENT '个性签名',
  `regtime` int(11) NOT NULL DEFAULT '0' COMMENT '注册时间',
  `lastlogintime` int(11) NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `logincount` int(11) NOT NULL DEFAULT '0' COMMENT '登录次数',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `avatar` varchar(100) NOT NULL DEFAULT '' COMMENT '头像',
  `content` varchar(1000) NOT NULL DEFAULT '' COMMENT '备注',
  `groupname` varchar(50) NOT NULL DEFAULT '' COMMENT '群名称',
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '会员类型 0游客 1主播',
  `backgroundpic` varchar(512) DEFAULT '' COMMENT '主播背景图片',
  `favorite` varchar(200) NOT NULL DEFAULT '' COMMENT '收藏',
  `favorite_audio` varchar(200) NOT NULL DEFAULT '' COMMENT '收藏节目',
  `favorite_playbill` varchar(200) NOT NULL DEFAULT '' COMMENT '收藏的节目单',
  `sort` int(4) DEFAULT '100',
  `program` varchar(500) NOT NULL DEFAULT '' COMMENT '主持的节目',
  `program_type` varchar(20) NOT NULL DEFAULT '' COMMENT '节目的类型',
  `attentionpays` int(10) NOT NULL DEFAULT '0' COMMENT '关注数',
  `IDcard` varchar(20) NOT NULL DEFAULT '' COMMENT '身份证号',
  `level` int(3) NOT NULL DEFAULT '0' COMMENT '等级',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=449 DEFAULT CHARSET=utf8 COMMENT='会员表';

--
-- 转存表中的数据 fm_member
--

INSERT INTO `fm_member` VALUES('430','0','wyb','9bad2764044171acdab696d32fb4c16d','韦永斌','','1','','','','','0','0','0','1','uploads/file/20150807/20150807154524_67400.jpg','','','0','','','','','100','','','0','','0');
INSERT INTO `fm_member` VALUES('431','0','member_test','537aa113887d88ffcf456473d20c28f7','会员测试账号','lkl','1','123@123.com','12345678901','外太空','就这么任性','1435720076','0','0','1','uploads/file/20150701/20150701050519_77228.jpg','<img src=\"uploads/file/20150701/20150701044849_64508.jpg\" alt=\"\" /><img src=\"uploads/image/20150701/20150701050327_98912.jpg\" alt=\"\" /><img src=\"uploads/image/20150701/20150701050545_52236.jpg\" alt=\"\" />','forever love','0','','','','','100','','','0','124562154879563','0');
INSERT INTO `fm_member` VALUES('433','0','fary','9bad2764044171acdab696d32fb4c16d','潇潇','','0','','13812154132','','','1437548057','0','0','1','','','','1','',',433','','','100','','','0','','0');
INSERT INTO `fm_member` VALUES('434','0','flla','9bad2764044171acdab696d32fb4c16d','翁玉','','0','','13845321548','','','1437548153','0','0','1','','','','0','','','','','100','','','0','','0');
INSERT INTO `fm_member` VALUES('435','0','测试账号','9bad2764044171acdab696d32fb4c16d','即可','','1','','1233468125','','','1437548273','0','0','1','','','','0','','','','','100','','','0','','0');
INSERT INTO `fm_member` VALUES('436','0','ceshi','9bad2764044171acdab696d32fb4c16d','测试账号2','','1','','1248459944','','','1437548338','0','0','1','','','','0','','','','','100','','','0','','0');
INSERT INTO `fm_member` VALUES('437','0','ceshi01','','测试账号3','123456','0','','412662215','','2158','1437548396','0','0','1','','','','1','','','','','100','','','0','','0');
INSERT INTO `fm_member` VALUES('438','0','ceshi02','9bad2764044171acdab696d32fb4c16d','小测','','0','','215966115962','','','1437548431','0','0','1','','','','0','','','','','100','','','0','','0');
INSERT INTO `fm_member` VALUES('439','0','user','9bad2764044171acdab696d32fb4c16d','小锡','','1','','1554961131','','','1437548469','0','0','1','','','','1','','','','','100','','','0','','0');
INSERT INTO `fm_member` VALUES('440','0','adddd','9bad2764044171acdab696d32fb4c16d','小哥','','0','','13541541151','','','1437548516','0','0','1','','','','0','','','','','100','','','0','','0');
INSERT INTO `fm_member` VALUES('441','0','ldy','9bad2764044171acdab696d32fb4c16d','小火','','1','','18275707300','','','1437548560','0','0','1','','','','1','','','','','100','','','0','','0');
INSERT INTO `fm_member` VALUES('442','0','123456','9bad2764044171acdab696d32fb4c16d','数字哥','','1','','1215745131','','','1437548610','0','0','1','','','','0','','','','','100','','','0','','0');
INSERT INTO `fm_member` VALUES('443','0','abc','9bad2764044171acdab696d32fb4c16d','字母哥','','1','','1515846141','','','1437548639','0','0','1','','','','0','','','','','100','','','0','','0');
INSERT INTO `fm_member` VALUES('445','0','lkl','2a0e6a8a3599c10631652f11d15f91d4','刘柯良','','1','123@123.com','','','','1437640556','0','0','1','','','','0','','','','','100','','','0','','0');
INSERT INTO `fm_member` VALUES('444','0','xc4','9bad2764044171acdab696d32fb4c16d','小小零','','1','','115633220','','','1437548686','0','0','1','','','','0','','','','','100','','','0','','0');
INSERT INTO `fm_member` VALUES('446','0','jxz','9bad2764044171acdab696d32fb4c16d','jxz','','1','','','','','1438139608','0','0','1','','','','0','','','','','100','','','0','','0');
INSERT INTO `fm_member` VALUES('447','0','username','9bad2764044171acdab696d32fb4c16d','哈哈','','0','1111333@163.com','1111111','','','1438153686','1438153686','0','1','','','','0','','','','','100','','','0','','0');
INSERT INTO `fm_member` VALUES('448','0','jhz','9bad2764044171acdab696d32fb4c16d','壬辰水','','0','12345678@qq.com','12345678912','','','1438154211','1438154211','0','1','uploads/file/20150805/20150805165434_80567.jpg','','','1','','','','','100','','','0','450324199807030754','0');
--
-- 表的结构fm_message
--

DROP TABLE IF EXISTS `fm_message`;
CREATE TABLE `fm_message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '私聊id',
  `from_uid` int(11) NOT NULL DEFAULT '0' COMMENT '发送方id',
  `to_uid` int(11) NOT NULL DEFAULT '0' COMMENT '接受方id',
  `title` varchar(500) NOT NULL DEFAULT '' COMMENT '内容',
  `audio` varchar(50) NOT NULL DEFAULT '' COMMENT '语音',
  `audio_time` smallint(6) NOT NULL DEFAULT '0' COMMENT '语音时长',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `isread` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已读',
  `thumb` varchar(100) NOT NULL COMMENT '图片',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 fm_message
--

INSERT INTO `fm_message` VALUES('1','9','14','私信范德萨发的发的','','0','161616561','1','1','');
INSERT INTO `fm_message` VALUES('2','15','14','fdsfdsfdfd','','0','5454433','1','1','');
INSERT INTO `fm_message` VALUES('3','18','14','Gfgg','','0','1387375528','1','1','');
INSERT INTO `fm_message` VALUES('4','14','10','哈咯','','0','1387377813','1','1','');
INSERT INTO `fm_message` VALUES('5','14','10','哈咯','','0','1387377815','1','1','');
INSERT INTO `fm_message` VALUES('6','9','14','jjjj','','0','1387378193','1','1','');
INSERT INTO `fm_message` VALUES('7','14','9','火锅恩','','0','1387378200','1','1','');
INSERT INTO `fm_message` VALUES('9','14','9','哈哈','','0','1387447373','1','1','');
INSERT INTO `fm_message` VALUES('10','14','9','','uploads/audio/20131219/20131219182727_12241.3gp','2','1387448847','1','1','');
INSERT INTO `fm_message` VALUES('11','9','10','测试','','0','1387552898','1','1','');
INSERT INTO `fm_message` VALUES('12','11','10','目前路况拥堵情况如何？','','0','1387560050','1','1','');
INSERT INTO `fm_message` VALUES('13','14','9','困死鸟','','0','1387779886','1','1','');
INSERT INTO `fm_message` VALUES('14','9','14','看看','','0','1387779991','1','1','');
INSERT INTO `fm_message` VALUES('15','14','11','啊吧','','0','1387780227','1','1','');
INSERT INTO `fm_message` VALUES('16','9','11','解决','','0','1387780313','1','1','');
INSERT INTO `fm_message` VALUES('17','9','11','测试','','0','1387780325','1','1','');
INSERT INTO `fm_message` VALUES('18','9','10','看看','','0','1387780715','1','1','');
INSERT INTO `fm_message` VALUES('19','9','27','测试下','','0','1387780726','1','1','');
INSERT INTO `fm_message` VALUES('20','14','11','测试','','0','1387780861','1','1','');
INSERT INTO `fm_message` VALUES('21','43','9','呵呵','','0','1387781825','1','1','');
INSERT INTO `fm_message` VALUES('22','43','9','hi','','0','1387781839','1','1','');
INSERT INTO `fm_message` VALUES('23','43','9','还不回？','','0','1387781855','1','1','');
INSERT INTO `fm_message` VALUES('24','42','43','嘿嘿','','0','1387781991','1','1','');
INSERT INTO `fm_message` VALUES('25','13','43','','uploads/audio/20131223/20131223151001_71086.3gp','2','1387782601','1','1','');
INSERT INTO `fm_message` VALUES('26','13','43','','uploads/audio/20131223/20131223151025_56796.3gp','2','1387782625','1','1','');
INSERT INTO `fm_message` VALUES('27','13','43','','uploads/audio/20131223/20131223151102_98783.3gp','7','1387782662','1','1','');
INSERT INTO `fm_message` VALUES('28','13','43','','uploads/audio/20131223/20131223151132_87824.3gp','7','1387782692','1','1','');
INSERT INTO `fm_message` VALUES('29','12','14','','uploads/audio/20131223/20131223151220_87063.3gp','1','1387782740','1','1','');
INSERT INTO `fm_message` VALUES('30','12','9','哈哈','','0','1387782905','1','1','');
INSERT INTO `fm_message` VALUES('31','12','9','你好','','0','1387782915','1','1','');
INSERT INTO `fm_message` VALUES('32','9','43','看看','','0','1387783157','1','1','');
INSERT INTO `fm_message` VALUES('33','42','43','','uploads/audio/20131223/20131223152025_24523.3gp','2','1387783225','1','1','');
INSERT INTO `fm_message` VALUES('34','14','43','测试','','0','1387783549','1','1','');
INSERT INTO `fm_message` VALUES('35','9','12','开开','','0','1387783611','1','1','');
INSERT INTO `fm_message` VALUES('36','42','10','不知道有没有提示','','0','1387785724','1','1','');
INSERT INTO `fm_message` VALUES('37','42','14','现在还堵车吗','','0','1387821360','1','1','');
INSERT INTO `fm_message` VALUES('38','42','11','还堵车吗','','0','1387821387','1','1','');
INSERT INTO `fm_message` VALUES('39','14','9','cessddfgggggg','','0','1387875661','1','1','');
INSERT INTO `fm_message` VALUES('40','9','14','来了','','0','1387882347','1','1','');
INSERT INTO `fm_message` VALUES('41','9','12','看看','','0','1387882362','1','1','');
INSERT INTO `fm_message` VALUES('42','23','14','Hi～','','0','1388327745','1','1','');
INSERT INTO `fm_message` VALUES('43','23','14','','uploads/audio/20131229/20131229223646_60366.3gp','3','1388327806','1','1','');
INSERT INTO `fm_message` VALUES('44','23','14','453','uploads/audio/20131229/20131229223656_44546.3gp','3','1388327816','1','1','');
INSERT INTO `fm_message` VALUES('45','23','14','453','uploads/audio/20131229/20131229223657_85893.3gp','3','1388327817','1','1','');
INSERT INTO `fm_message` VALUES('46','23','14','','uploads/audio/20131229/20131229223701_33222.3gp','3','1388327821','1','1','');
INSERT INTO `fm_message` VALUES('47','23','14','','uploads/audio/20131229/20131229223703_74967.3gp','3','1388327823','1','1','');
INSERT INTO `fm_message` VALUES('48','23','14','','uploads/audio/20131229/20131229223704_74231.3gp','3','1388327824','1','1','');
INSERT INTO `fm_message` VALUES('49','23','14','453','uploads/audio/20131229/20131229223714_76681.3gp','3','1388327834','1','1','');
INSERT INTO `fm_message` VALUES('50','23','9','123','','0','1388327875','1','1','');
INSERT INTO `fm_message` VALUES('51','14','23','','uploads/audio/20131229/20131229224135_94992.3gp','1','1388328095','1','1','');
INSERT INTO `fm_message` VALUES('52','14','23','','uploads/audio/20131229/20131229224145_91990.3gp','1','1388328105','1','1','');
INSERT INTO `fm_message` VALUES('53','23','14','','','0','1388328133','1','1','');
INSERT INTO `fm_message` VALUES('54','23','14','','','0','1388328134','1','1','');
INSERT INTO `fm_message` VALUES('55','14','23','哈哈','','0','1388391789','1','1','');
INSERT INTO `fm_message` VALUES('56','14','23','','uploads/audio/20131230/20131230162313_32689.3gp','1','1388391793','1','1','');
INSERT INTO `fm_message` VALUES('57','45','14','哈喽','','0','1389685881','1','1','');
INSERT INTO `fm_message` VALUES('58','45','14','呵呵','','0','1389685890','0','1','');
INSERT INTO `fm_message` VALUES('59','23','14','','','0','1396099754','1','1','');
INSERT INTO `fm_message` VALUES('60','23','14','','','0','1396099755','1','1','');
INSERT INTO `fm_message` VALUES('61','23','14','3327892','','0','1396099765','1','1','');
INSERT INTO `fm_message` VALUES('62','23','14','','','0','1396099766','1','1','');
INSERT INTO `fm_message` VALUES('63','23','14','','','0','1396099767','1','1','');
INSERT INTO `fm_message` VALUES('64','23','14','','uploads/audio/20140329/20140329212945_25636.3gp','1','1396099785','1','1','');
INSERT INTO `fm_message` VALUES('65','23','14','','uploads/audio/20140329/20140329212948_82523.3gp','1','1396099788','1','1','');
INSERT INTO `fm_message` VALUES('66','23','14','','uploads/audio/20140329/20140329212950_58257.3gp','1','1396099790','1','1','');
INSERT INTO `fm_message` VALUES('67','23','14','','uploads/audio/20140329/20140329212951_12562.3gp','1','1396099791','1','1','');
INSERT INTO `fm_message` VALUES('68','47','46','啦啦啦啦啦啦','','0','1397899304','1','0','');
INSERT INTO `fm_message` VALUES('69','47','46','可口可乐','','0','1397900850','1','0','');
INSERT INTO `fm_message` VALUES('70','47','46','来看看魔','','0','1397900855','1','0','');
INSERT INTO `fm_message` VALUES('71','47','46','老师','','0','1397901476','1','0','');
INSERT INTO `fm_message` VALUES('72','14','45','rfff','','0','1400228059','1','0','');
INSERT INTO `fm_message` VALUES('73','79','9','测试','','0','1414728885','1','0','');
INSERT INTO `fm_message` VALUES('74','79','9','哈哈哈','','0','1414752692','1','0','');
INSERT INTO `fm_message` VALUES('75','79','84','嘎嘎','','0','1414753580','1','0','');
INSERT INTO `fm_message` VALUES('76','79','151','时尚','','0','1414753634','1','0','');
INSERT INTO `fm_message` VALUES('77','9','80','发给','','0','1414754782','1','0','');
--
-- 表的结构fm_permission
--

DROP TABLE IF EXISTS `fm_permission`;
CREATE TABLE `fm_permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_list` mediumtext,
  `catid` int(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 fm_permission
--

INSERT INTO `fm_permission` VALUES('1','[\"stat\",\"content\",\"channel_list\",\"channel_add\",\"channel_edit\",\"channel_del\",\"program_list\",\"program_add\",\"program_edit\",\"program_check\",\"program_tj\",\"program_sy\",\"program_del\",\"program_type_list\",\"program_type_add\",\"program_type_edit\",\"program_type_del\",\"programme\",\"programme_view\",\"programme_add\",\"programme_edit\",\"programme_del\",\"interaction\",\"comment\",\"comment_check\",\"comment_edit\",\"comment_del\",\"message\",\"message_check\",\"message_edit\",\"message_del\",\"feedback\",\"feedback_del\",\"member\",\"member_list\",\"member_add\",\"member_check\",\"member_edit\",\"member_del\",\"admin\",\"admin_list\",\"admin_add\",\"admin_edit\",\"admin_del\",\"admin_set\",\"admin_set_save\",\"adminlog\",\"loginlog\",\"cache\",\"role_list\",\"role_add\",\"role_edit\",\"role_del\",\"permission\",\"permission_edit\",\"badword_list\",\"badword_add\",\"badword_edit\",\"badword_del\",\"database\",\"database_bak\",\"database_res\",\"database_del\"]','1');
INSERT INTO `fm_permission` VALUES('2','[\"stat\",\"traffictext\",\"traffictext_list\",\"traffictext_add\",\"traffictext_check\",\"traffictext_edit\",\"traffictext_del\",\"trafficmap\",\"trafficmap_add\",\"trafficmap_del\",\"singleline\",\"singleline_add\",\"singleline_del\",\"comment\",\"comment_edit\",\"comment_del\",\"traffictext_reports\",\"traffictext_reports_check\",\"traffictext_reports_del\",\"news\",\"news_list\",\"news_add\",\"news_template_manager\",\"news_template\",\"news_edit\",\"news_del\",\"notice\",\"notice_add\",\"notice_edit\",\"notice_del\",\"action\",\"action_add\",\"action_edit\",\"action_del\",\"schedule\",\"schedule_add\",\"schedule_edit\",\"schedule_del\",\"guestbook\",\"guestbook_edit\",\"guestbook_del\",\"radio\",\"radio_add\",\"radio_check\",\"radio_edit\",\"radio_del\",\"message\",\"message_check\",\"message_edit\",\"message_del\",\"askway\",\"askway_check\",\"askway_edit\",\"askway_del\",\"askanswer\",\"askanswer_edit\",\"askanswer_del\",\"groups\",\"groups_list\",\"groups_add\",\"groups_check\",\"groups_edit\",\"groups_del\",\"groups_chats\",\"groups_chats_add\",\"groups_chats_edit\",\"groups_chats_del\",\"weibo\",\"weixin_lk\",\"weixin_lk_list\",\"weixin_lk_add\",\"weixin_lk_edit\",\"weixin_lk_del\",\"weixin_gslk_list\",\"weixin_gslk_add\",\"weixin_gslk_edit\",\"weixin_gslk_del\",\"weixin_sg_list\",\"weixin_sg_add\",\"weixin_sg_edit\",\"weixin_sg_del\",\"music_list\",\"music_edit\",\"weixin_menu\",\"weixin_menu_saveandapply\",\"weixin_menu_edit\",\"weixin_menu_del\",\"weixin_text_list\",\"weixin_text_add\",\"weixin_text_edit\",\"weixin_text_del\",\"weixin_news_list\",\"weixin_news_add\",\"weixin_news_edit\",\"weixin_news_del\",\"weixin_set\",\"weixin_set_save\",\"news_title\",\"news_title_add\",\"news_title_check\",\"news_title_edit\",\"news_title_del\",\"member\",\"member_list\",\"member_add\",\"member_check\",\"member_edit\",\"member_del\",\"admin\",\"admin_list\",\"admin_add\",\"admin_edit\",\"admin_del\",\"admin_set\",\"admin_set_save\",\"adminlog\",\"loginlog\",\"cache\",\"permission\"]','2');
--
-- 表的结构fm_program
--

DROP TABLE IF EXISTS `fm_program`;
CREATE TABLE `fm_program` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '节目名称',
  `description` varchar(100) NOT NULL DEFAULT '' COMMENT '节目简介',
  `content` text NOT NULL COMMENT '节目内容',
  `thumb` varchar(100) NOT NULL DEFAULT '' COMMENT '缩略图',
  `path` varchar(100) NOT NULL DEFAULT '' COMMENT '节目地址',
  `program_time` varchar(10) NOT NULL DEFAULT '' COMMENT '节目时长',
  `playtimes` int(10) NOT NULL DEFAULT '0' COMMENT '收听量',
  `zantimes` int(10) NOT NULL DEFAULT '0' COMMENT '点赞次数',
  `sharetimes` int(10) NOT NULL DEFAULT '0' COMMENT '分享次数',
  `downloadtimes` int(10) NOT NULL DEFAULT '0' COMMENT '下载次数',
  `type_id` int(4) NOT NULL DEFAULT '0' COMMENT '节目类型',
  `sort` int(8) NOT NULL DEFAULT '0' COMMENT '排序',
  `channel_id` int(10) NOT NULL DEFAULT '0' COMMENT '频道id',
  `mid` int(10) NOT NULL DEFAULT '0' COMMENT '会员id，节目所有者',
  `status` int(2) NOT NULL DEFAULT '0' COMMENT '状态',
  `addtime` int(11) NOT NULL DEFAULT '0',
  `show_homepage` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否显示在首页轮播',
  `hot` tinyint(1) NOT NULL DEFAULT '0' COMMENT '热门推荐在首页',
  `type_pid` int(4) DEFAULT NULL COMMENT '次级分类',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 fm_program
--

INSERT INTO `fm_program` VALUES('1','节目测试','节目测试','节目测试','uploads/file/20150701/20150701050519_77228.jpg','uploads/1.mp3','12:23','2','0','0','0','1','0','2','430','1','1435802405','1','1','18');
INSERT INTO `fm_program` VALUES('2','test','test','test2','uploads/file/20150702/20150702111703_66744.jpg','uploads/file/20150702/20150702111753_75387.mp3','','0','0','0','0','3','2','2','430','1','1435828687','0','1','0');
INSERT INTO `fm_program` VALUES('4','测试节目1','','','uploads/file/20150806/20150806093445_45164.jpg','uploads/file/20150707/20150707053311_35900.mp3','','0','0','0','0','5','50','4','430','1','1436240017','0','1','0');
INSERT INTO `fm_program` VALUES('5','l测试','测试','121','uploads/file/20150806/20150806101538_44801.jpg','uploads/file/20150722/20150722161620_69073.mp3','','0','0','0','0','1','1','2','430','1','1437553152','0','0','0');
INSERT INTO `fm_program` VALUES('6','最后的繁华','','惺惺相惜','uploads/file/20150722/20150722164615_32870.jpg','uploads/file/20150722/20150722164324_39918.mp3','','0','0','0','0','1','1','2','444','1','1437554786','0','0','0');
INSERT INTO `fm_program` VALUES('7','天空才是极限','一个','想','uploads/file/20150722/20150722165024_54088.jpg','uploads/file/20150722/20150722164924_24685.mp3','','0','0','0','0','8','1','2','443','1','1437555051','0','0','0');
INSERT INTO `fm_program` VALUES('8','无与伦比','','zzzzzzzzz','uploads/file/20150722/20150722165330_47282.jpg','uploads/file/20150722/20150722165503_79749.mp3','','9','0','0','0','12','1','2','442','1','1437555385','0','0','0');
INSERT INTO `fm_program` VALUES('9','净化心灵','','在','uploads/file/20150722/20150722170411_59089.jpg','uploads/file/20150722/20150722170401_50536.mp3','','0','0','0','0','5','1','2','441','1','1437555870','0','0','0');
INSERT INTO `fm_program` VALUES('10','芳华绝代','ches','现场总线','uploads/file/20150722/20150722170532_34433.jpg','uploads/file/20150722/20150722170557_32173.mp3','','5','0','0','0','15','1','2','440','1','1437555989','1','0','0');
INSERT INTO `fm_program` VALUES('11','美丽天空','','','uploads/file/20150722/20150722170758_73067.jpg','uploads/file/20150722/20150722170725_13974.mp3','','3','0','0','0','6','1','2','439','1','1437556090','1','0','0');
INSERT INTO `fm_program` VALUES('12','一个老地方','测试','1','uploads/file/20150806/20150806093427_17135.jpg','uploads/file/20150722/20150722171424_28926.mp3','','3','0','0','0','10','1','2','438','1','1437556475','0','0','0');
INSERT INTO `fm_program` VALUES('13','风吹浪打','自行车','想','uploads/file/20150806/20150806093404_47658.jpg','uploads/file/20150722/20150722171631_25086.mp3','','0','0','0','0','17','1','2','437','1','1437556610','0','0','0');
INSERT INTO `fm_program` VALUES('14','一个人的行李','','才','uploads/file/20150806/20150806093341_58111.jpg','uploads/file/20150722/20150722172011_69949.mp3','','0','0','0','0','9','1','2','436','1','1437556822','0','0','0');
INSERT INTO `fm_program` VALUES('15','希望的原野','','才','uploads/file/20150806/20150806093145_76783.jpg','uploads/file/20150722/20150722172234_30709.mp3','','1','0','0','0','4','1','2','435','1','1437556975','0','0','0');
INSERT INTO `fm_program` VALUES('16','风雨无阻','歌曲','','uploads/file/20150806/20150806093126_19610.jpg','uploads/file/20150804/20150804110221_19714.mp3','','0','0','0','0','16','100','4','433','1','1438678961','0','0','18');
INSERT INTO `fm_program` VALUES('17','分类统计测试节目','分类统计测试节目','分类统计测试节目','uploads/file/20150806/20150806093018_44876.jpg','uploads/file/20150805/20150805041922_19214.mp3','','0','0','0','0','16','0','4','445','1','1433088000','0','0','18');
INSERT INTO `fm_program` VALUES('19','风影依旧','故事','','uploads/file/20150806/20150806092921_91850.jpg','uploads/file/20150805/20150805043640_26408.mp3','','0','0','0','0','1','100','4','433','1','1438742212','0','0','');
INSERT INTO `fm_program` VALUES('20','同一个家','测试','','','uploads/file/20150811/20150811114818_62347.mp3','','0','0','0','0','1','0','4','433','0','1439264907','0','0','');
--
-- 表的结构fm_program_comment
--

DROP TABLE IF EXISTS `fm_program_comment`;
CREATE TABLE `fm_program_comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mid` int(10) unsigned NOT NULL DEFAULT '0',
  `program_id` int(10) unsigned NOT NULL DEFAULT '0',
  `content` varchar(255) NOT NULL DEFAULT '',
  `audio` varchar(100) NOT NULL DEFAULT '',
  `audio_time` smallint(5) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `traffic_id` (`program_id`)
) ENGINE=MyISAM AUTO_INCREMENT=259 DEFAULT CHARSET=utf8 COMMENT='评论表';

--
-- 转存表中的数据 fm_program_comment
--

INSERT INTO `fm_program_comment` VALUES('1','430','1','这首歌很不错哦','uploads/file/20150702/20150702111753_75387.mp3','0','1435802405');
--
-- 表的结构fm_program_data
--

DROP TABLE IF EXISTS `fm_program_data`;
CREATE TABLE `fm_program_data` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `mid` int(10) NOT NULL DEFAULT '0' COMMENT '会员id',
  `program_id` int(10) NOT NULL DEFAULT '0' COMMENT '节目id',
  `type` int(2) NOT NULL DEFAULT '0' COMMENT '1为收藏，2是下载，3是播放过',
  `addtime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 fm_program_data
--

INSERT INTO `fm_program_data` VALUES('1','430','1','1','0');
--
-- 表的结构fm_program_type
--

DROP TABLE IF EXISTS `fm_program_type`;
CREATE TABLE `fm_program_type` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(25) NOT NULL DEFAULT '' COMMENT '类型名称',
  `sort` int(8) NOT NULL DEFAULT '0' COMMENT '排序',
  `addtime` int(11) NOT NULL DEFAULT '0',
  `thumb` varchar(100) NOT NULL,
  `pid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 fm_program_type
--

INSERT INTO `fm_program_type` VALUES('1','情感','3','1435890508','','0');
INSERT INTO `fm_program_type` VALUES('3','音乐','2','1435890733','','0');
INSERT INTO `fm_program_type` VALUES('4','新闻','6','1435907042','uploads/file/20150706/20150706032726_86959.jpg','0');
INSERT INTO `fm_program_type` VALUES('5','笑话','3','1436144700','uploads/file/20150706/20150706030457_61185.jpg','0');
INSERT INTO `fm_program_type` VALUES('6','综艺娱乐','100','1437548859','','0');
INSERT INTO `fm_program_type` VALUES('7','校园','100','1437548902','','0');
INSERT INTO `fm_program_type` VALUES('8','历史文人','100','1437548920','','0');
INSERT INTO `fm_program_type` VALUES('9','健康养生','100','1437548942','','0');
INSERT INTO `fm_program_type` VALUES('10','旅游','100','1437548961','','0');
INSERT INTO `fm_program_type` VALUES('11','汽车','100','1437548975','','0');
INSERT INTO `fm_program_type` VALUES('12','儿童','100','1437548988','','0');
INSERT INTO `fm_program_type` VALUES('13','游戏','100','1437549001','','0');
INSERT INTO `fm_program_type` VALUES('14','校园','100','1437549009','','0');
INSERT INTO `fm_program_type` VALUES('15','戏曲','100','1437549045','','0');
INSERT INTO `fm_program_type` VALUES('16','有声小说','100','1437549071','','0');
INSERT INTO `fm_program_type` VALUES('17','商业财经','100','1437549099','','0');
INSERT INTO `fm_program_type` VALUES('18','武侠','100','1437549071',' ','16');
INSERT INTO `fm_program_type` VALUES('19','古龙','0','1438654152','','16');
INSERT INTO `fm_program_type` VALUES('20','都市情感','100','1438825035','','16');
INSERT INTO `fm_program_type` VALUES('21','股市','100','1438855727','','17');
INSERT INTO `fm_program_type` VALUES('22','基金','100','1438855796','','17');
--
-- 表的结构fm_programme
--

DROP TABLE IF EXISTS `fm_programme`;
CREATE TABLE `fm_programme` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '节目单id',
  `title` varchar(50) NOT NULL COMMENT '节目单名称',
  `mid` int(10) NOT NULL COMMENT '用户id',
  `program_ids` text NOT NULL COMMENT '节目id数组',
  `intro` varchar(100) NOT NULL COMMENT '节目单简介',
  `content` varchar(200) NOT NULL DEFAULT '0' COMMENT '节目单内容介绍',
  `channel_id` int(10) NOT NULL COMMENT '所属频道id',
  `addtime` varchar(20) NOT NULL COMMENT '创建时间',
  `playtimes` int(10) NOT NULL DEFAULT '0' COMMENT '播放次数',
  `thumb` varchar(100) NOT NULL DEFAULT '0' COMMENT '节目单封面图片',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 fm_programme
--

INSERT INTO `fm_programme` VALUES('1','节目单添加测试','448','1,2,4,6,7,8,9,10,11','节目单添加测试','program_ids','2','1437615310','0','uploads/file/20150724/20150724095638_31747.jpg');
INSERT INTO `fm_programme` VALUES('2','接口测试','444','1,2,3,4,5,6,7,8,9','测试','0','5','1438916722','0','0');
--
-- 表的结构fm_report_all
--

DROP TABLE IF EXISTS `fm_report_all`;
CREATE TABLE `fm_report_all` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '举报id',
  `program_id` int(11) NOT NULL COMMENT '被举报节目id',
  `content` varchar(100) NOT NULL COMMENT '举报内容',
  `mid` int(11) NOT NULL COMMENT '举报人id',
  `addtime` varchar(11) NOT NULL COMMENT '举报时间',
  `status` int(1) NOT NULL COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 fm_report_all
--

INSERT INTO `fm_report_all` VALUES('1','1','测试','445','1437615310','0');
--
-- 表的结构fm_role_group
--

DROP TABLE IF EXISTS `fm_role_group`;
CREATE TABLE `fm_role_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) DEFAULT NULL,
  `addtime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 fm_role_group
--

INSERT INTO `fm_role_group` VALUES('1','超级管理员','');
INSERT INTO `fm_role_group` VALUES('2','普遍管理员','');
INSERT INTO `fm_role_group` VALUES('3','1003','1420689596');
--
-- 表的结构fm_stat
--

DROP TABLE IF EXISTS `fm_stat`;
CREATE TABLE `fm_stat` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mid` int(10) unsigned NOT NULL DEFAULT '0',
  `city` varchar(30) NOT NULL DEFAULT '',
  `district` varchar(30) NOT NULL DEFAULT '',
  `lnglat` varchar(30) NOT NULL DEFAULT '',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `version` varchar(20) NOT NULL DEFAULT '' COMMENT '客户端版本',
  `os_version` varchar(20) NOT NULL DEFAULT '' COMMENT '手机系统版本',
  `phone_model` varchar(20) NOT NULL DEFAULT '' COMMENT '手机型号',
  `phone_brand` varchar(20) NOT NULL DEFAULT '' COMMENT '手机品牌',
  `phone_os` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1为Android，2为IOS',
  `isfirst` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0不是首次安装，1是首次安装',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3863 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 fm_stat
--

INSERT INTO `fm_stat` VALUES('1','445','南宁','华南','','172.0.0.1','1435624587','1.0','4.4','水果机','大水果','1','1');
INSERT INTO `fm_stat` VALUES('2','445','南宁','华南','','172.0.0.1','1434510000','1.0','4.4','水果机','大水果','1','0');
INSERT INTO `fm_stat` VALUES('3','445','','','','','1438139736','','','','','1','1');
INSERT INTO `fm_stat` VALUES('4','445','','','','','1438223352','','','','','1','1');
INSERT INTO `fm_stat` VALUES('5','445','','','','','1438215352','','','','','2','1');
INSERT INTO `fm_stat` VALUES('6','445','','','','','1438225352','','','','','1','1');
INSERT INTO `fm_stat` VALUES('7','445','','','','','1438223352','','','','','2','1');
INSERT INTO `fm_stat` VALUES('8','445','','','','','1438223352','','','','','2','1');
--
-- 表的结构fm_times
--

DROP TABLE IF EXISTS `fm_times`;
CREATE TABLE `fm_times` (
  `username` char(40) NOT NULL,
  `ip` char(15) NOT NULL,
  `logintime` int(10) unsigned NOT NULL DEFAULT '0',
  `isadmin` tinyint(1) NOT NULL DEFAULT '0',
  `times` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`username`,`isadmin`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 fm_times
--

