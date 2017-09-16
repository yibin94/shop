USE shop;
SET NAMES utf8;

CREATE TABLE IF NOT EXISTS shop_goods
(
   id mediumint unsigned not null auto_increment,
   goods_name varchar(45) not null comment '商品名称',
   logo varchar(150) not null default '' comment '商品logo',
   sm_logo varchar(150) not null default '' comment '商品缩略图logo',
   price decimal(10,2) not null default '0.00' comment '商品价格',
   goods_desc longtext comment '商品描述',
   is_on_sale tinyint unsigned not null default '1' comment '是否上架：1-上架，0-下架',
   is_delete tinyint unsigned not null default '0' comment '是否删除，1-已删除，0-未删除',
   addtime int unsigned not null comment '添加时间',
   primary key(id),
   key price(price),
   key is_on_sale(is_on_sale),
   key is_delete(is_delete),
   key addtime(addtime)
)engine=MyISAM default charset=utf8;

#如果需要支持"事务"的数据表则使用Innodb引擎。
#tinyint : 0~255
#smallint : 0~65535
#mediumint : 0~一千六百多万
#int : 0~40多亿
#char : 0~255个字符
#varchar : 0~65535个字节，看表编码，utf8(一个汉字3个字节),gbk(一个汉字2个字节).
#text : 0~65535个字符
#select * FROM shop_goods WHERE goods_name LIKE '%xxx%';
#说明：当要使用LIKE查询并以%开头时，不能使用#普通索引，只能使用全文索引，如果使用了全文索引，则sql#语句如下：SELECT * FROM shop_goods WHERE MATCH goods_name AGAINST 'xxx';
#但MYSQL自带的全文索引不支持中文，所以不能使用MYSQL自带#的全文索引功能，如果要优化只能使用第#三方的全文索引引擎，如：sphinx,lucence等。
#添加索引：index/key
