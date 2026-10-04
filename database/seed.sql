--
-- Table structure for table `wp_commentmeta`
--

DROP TABLE IF EXISTS `wp_commentmeta`;
CREATE TABLE `wp_commentmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext DEFAULT NULL,
  PRIMARY KEY (`meta_id`),
  KEY `comment_id` (`comment_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Table structure for table `wp_comments`
--

DROP TABLE IF EXISTS `wp_comments`;
CREATE TABLE `wp_comments` (
  `comment_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment_post_ID` bigint(20) unsigned NOT NULL DEFAULT '0',
  `comment_author` tinytext NOT NULL,
  `comment_author_email` varchar(100) NOT NULL DEFAULT '',
  `comment_author_url` varchar(200) NOT NULL DEFAULT '',
  `comment_author_IP` varchar(100) NOT NULL DEFAULT '',
  `comment_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_content` text NOT NULL,
  `comment_karma` int(11) NOT NULL DEFAULT '0',
  `comment_approved` varchar(20) NOT NULL DEFAULT '1',
  `comment_agent` varchar(255) NOT NULL DEFAULT '',
  `comment_type` varchar(20) NOT NULL DEFAULT 'comment',
  `comment_parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`comment_ID`),
  KEY `comment_post_ID` (`comment_post_ID`),
  KEY `comment_approved_date_gmt` (`comment_approved`, `comment_date_gmt`),
  KEY `comment_date_gmt` (`comment_date_gmt`),
  KEY `comment_parent` (`comment_parent`),
  KEY `comment_author_email` (`comment_author_email`(10))
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `wp_comments`
--

INSERT INTO `wp_comments` VALUES (1,1,'A WordPress Commenter','wapuu@wordpress.example','https://wordpress.org/','','2026-08-28 14:57:36','2026-08-28 14:57:36','Hi, this is a comment.\nTo get started with moderating, editing, and deleting comments, please visit the Comments screen in the dashboard.\nCommenter avatars come from <a href="https://gravatar.com/">Gravatar</a>.',0,1,'','comment',0,0);

--
-- Table structure for table `wp_links`
--

DROP TABLE IF EXISTS `wp_links`;
CREATE TABLE `wp_links` (
  `link_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `link_url` varchar(255) NOT NULL DEFAULT '',
  `link_name` varchar(255) NOT NULL DEFAULT '',
  `link_image` varchar(255) NOT NULL DEFAULT '',
  `link_target` varchar(25) NOT NULL DEFAULT '',
  `link_description` varchar(255) NOT NULL DEFAULT '',
  `link_visible` varchar(20) NOT NULL DEFAULT 'Y',
  `link_owner` bigint(20) unsigned NOT NULL DEFAULT '1',
  `link_rating` int(11) NOT NULL DEFAULT '0',
  `link_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `link_rel` varchar(255) NOT NULL DEFAULT '',
  `link_notes` mediumtext NOT NULL,
  `link_rss` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`link_id`),
  KEY `link_visible` (`link_visible`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Table structure for table `wp_options`
--

DROP TABLE IF EXISTS `wp_options`;
CREATE TABLE `wp_options` (
  `option_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `option_name` varchar(191) NOT NULL DEFAULT '',
  `option_value` longtext NOT NULL,
  `autoload` varchar(20) NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`option_id`),
  UNIQUE KEY `option_name` (`option_name`),
  KEY `autoload` (`autoload`)
) ENGINE=InnoDB AUTO_INCREMENT=489 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `wp_options`
--

INSERT INTO `wp_options` VALUES (1,'siteurl','http://localhost:8881','on');
INSERT INTO `wp_options` VALUES (2,'home','http://localhost:8881','on');
INSERT INTO `wp_options` VALUES (3,'blogname','Rashtrotthana_yoga_centre','on');
INSERT INTO `wp_options` VALUES (4,'blogdescription','','on');
INSERT INTO `wp_options` VALUES (5,'users_can_register',0,'on');
INSERT INTO `wp_options` VALUES (6,'admin_email','admin@localhost.com','on');
INSERT INTO `wp_options` VALUES (7,'start_of_week',1,'on');
INSERT INTO `wp_options` VALUES (8,'use_balanceTags',0,'on');
INSERT INTO `wp_options` VALUES (9,'use_smilies',1,'on');
INSERT INTO `wp_options` VALUES (10,'require_name_email',1,'on');
INSERT INTO `wp_options` VALUES (11,'comments_notify',1,'on');
INSERT INTO `wp_options` VALUES (12,'posts_per_rss',10,'on');
INSERT INTO `wp_options` VALUES (13,'rss_use_excerpt',0,'on');
INSERT INTO `wp_options` VALUES (14,'mailserver_url','mail.example.com','on');
INSERT INTO `wp_options` VALUES (15,'mailserver_login','login@example.com','on');
INSERT INTO `wp_options` VALUES (16,'mailserver_pass','','on');
INSERT INTO `wp_options` VALUES (17,'mailserver_port',110,'on');
INSERT INTO `wp_options` VALUES (18,'default_category',1,'on');
INSERT INTO `wp_options` VALUES (19,'default_comment_status','open','on');
INSERT INTO `wp_options` VALUES (20,'default_ping_status','open','on');
INSERT INTO `wp_options` VALUES (21,'default_pingback_flag',1,'on');
INSERT INTO `wp_options` VALUES (22,'posts_per_page',10,'on');
INSERT INTO `wp_options` VALUES (23,'date_format','F j, Y','on');
INSERT INTO `wp_options` VALUES (24,'time_format','g:i a','on');
INSERT INTO `wp_options` VALUES (25,'links_updated_date_format','F j, Y g:i a','on');
INSERT INTO `wp_options` VALUES (26,'comment_moderation',0,'on');
INSERT INTO `wp_options` VALUES (27,'moderation_notify',1,'on');
INSERT INTO `wp_options` VALUES (28,'permalink_structure','/%year%/%monthnum%/%day%/%postname%/','on');
INSERT INTO `wp_options` VALUES (29,'rewrite_rules','a:254:{s:11:"^wp-json/?$";s:22:"index.php?rest_route=/";s:14:"^wp-json/(.*)?";s:33:"index.php?rest_route=/$matches[1]";s:21:"^index.php/wp-json/?$";s:22:"index.php?rest_route=/";s:24:"^index.php/wp-json/(.*)?";s:33:"index.php?rest_route=/$matches[1]";s:17:"^wp-sitemap\\.xml$";s:23:"index.php?sitemap=index";s:17:"^wp-sitemap\\.xsl$";s:36:"index.php?sitemap-stylesheet=sitemap";s:23:"^wp-sitemap-index\\.xsl$";s:34:"index.php?sitemap-stylesheet=index";s:48:"^wp-sitemap-([a-z]+?)-([a-z\\d_-]+?)-(\\d+?)\\.xml$";s:75:"index.php?sitemap=$matches[1]&sitemap-subtype=$matches[2]&paged=$matches[3]";s:34:"^wp-sitemap-([a-z]+?)-(\\d+?)\\.xml$";s:47:"index.php?sitemap=$matches[1]&paged=$matches[2]";s:12:"resources/?$";s:28:"index.php?post_type=resource";s:42:"resources/feed/(feed|rdf|rss|rss2|atom)/?$";s:45:"index.php?post_type=resource&feed=$matches[1]";s:37:"resources/(feed|rdf|rss|rss2|atom)/?$";s:45:"index.php?post_type=resource&feed=$matches[1]";s:29:"resources/page/([0-9]{1,})/?$";s:46:"index.php?post_type=resource&paged=$matches[1]";s:8:"event/?$";s:28:"index.php?post_type=rs_event";s:38:"event/feed/(feed|rdf|rss|rss2|atom)/?$";s:45:"index.php?post_type=rs_event&feed=$matches[1]";s:33:"event/(feed|rdf|rss|rss2|atom)/?$";s:45:"index.php?post_type=rs_event&feed=$matches[1]";s:25:"event/page/([0-9]{1,})/?$";s:46:"index.php?post_type=rs_event&paged=$matches[1]";s:47:"category/(.+?)/feed/(feed|rdf|rss|rss2|atom)/?$";s:52:"index.php?category_name=$matches[1]&feed=$matches[2]";s:42:"category/(.+?)/(feed|rdf|rss|rss2|atom)/?$";s:52:"index.php?category_name=$matches[1]&feed=$matches[2]";s:23:"category/(.+?)/embed/?$";s:46:"index.php?category_name=$matches[1]&embed=true";s:35:"category/(.+?)/page/?([0-9]{1,})/?$";s:53:"index.php?category_name=$matches[1]&paged=$matches[2]";s:17:"category/(.+?)/?$";s:35:"index.php?category_name=$matches[1]";s:44:"tag/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:42:"index.php?tag=$matches[1]&feed=$matches[2]";s:39:"tag/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:42:"index.php?tag=$matches[1]&feed=$matches[2]";s:20:"tag/([^/]+)/embed/?$";s:36:"index.php?tag=$matches[1]&embed=true";s:32:"tag/([^/]+)/page/?([0-9]{1,})/?$";s:43:"index.php?tag=$matches[1]&paged=$matches[2]";s:14:"tag/([^/]+)/?$";s:25:"index.php?tag=$matches[1]";s:45:"type/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:50:"index.php?post_format=$matches[1]&feed=$matches[2]";s:40:"type/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:50:"index.php?post_format=$matches[1]&feed=$matches[2]";s:21:"type/([^/]+)/embed/?$";s:44:"index.php?post_format=$matches[1]&embed=true";s:33:"type/([^/]+)/page/?([0-9]{1,})/?$";s:51:"index.php?post_format=$matches[1]&paged=$matches[2]";s:15:"type/([^/]+)/?$";s:33:"index.php?post_format=$matches[1]";s:36:"activity/[^/]+/attachment/([^/]+)/?$";s:32:"index.php?attachment=$matches[1]";s:46:"activity/[^/]+/attachment/([^/]+)/trackback/?$";s:37:"index.php?attachment=$matches[1]&tb=1";s:66:"activity/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:61:"activity/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:61:"activity/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$";s:50:"index.php?attachment=$matches[1]&cpage=$matches[2]";s:42:"activity/[^/]+/attachment/([^/]+)/embed/?$";s:43:"index.php?attachment=$matches[1]&embed=true";s:25:"activity/([^/]+)/embed/?$";s:44:"index.php?rs_activity=$matches[1]&embed=true";s:29:"activity/([^/]+)/trackback/?$";s:38:"index.php?rs_activity=$matches[1]&tb=1";s:37:"activity/([^/]+)/page/?([0-9]{1,})/?$";s:51:"index.php?rs_activity=$matches[1]&paged=$matches[2]";s:44:"activity/([^/]+)/comment-page-([0-9]{1,})/?$";s:51:"index.php?rs_activity=$matches[1]&cpage=$matches[2]";s:33:"activity/([^/]+)(?:/([0-9]+))?/?$";s:50:"index.php?rs_activity=$matches[1]&page=$matches[2]";s:25:"activity/[^/]+/([^/]+)/?$";s:32:"index.php?attachment=$matches[1]";s:35:"activity/[^/]+/([^/]+)/trackback/?$";s:37:"index.php?attachment=$matches[1]&tb=1";s:55:"activity/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:50:"activity/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:50:"activity/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$";s:50:"index.php?attachment=$matches[1]&cpage=$matches[2]";s:31:"activity/[^/]+/([^/]+)/embed/?$";s:43:"index.php?attachment=$matches[1]&embed=true";s:34:"center/[^/]+/attachment/([^/]+)/?$";s:32:"index.php?attachment=$matches[1]";s:44:"center/[^/]+/attachment/([^/]+)/trackback/?$";s:37:"index.php?attachment=$matches[1]&tb=1";s:64:"center/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:59:"center/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:59:"center/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$";s:50:"index.php?attachment=$matches[1]&cpage=$matches[2]";s:40:"center/[^/]+/attachment/([^/]+)/embed/?$";s:43:"index.php?attachment=$matches[1]&embed=true";s:23:"center/([^/]+)/embed/?$";s:42:"index.php?rs_center=$matches[1]&embed=true";s:27:"center/([^/]+)/trackback/?$";s:36:"index.php?rs_center=$matches[1]&tb=1";s:35:"center/([^/]+)/page/?([0-9]{1,})/?$";s:49:"index.php?rs_center=$matches[1]&paged=$matches[2]";s:42:"center/([^/]+)/comment-page-([0-9]{1,})/?$";s:49:"index.php?rs_center=$matches[1]&cpage=$matches[2]";s:31:"center/([^/]+)(?:/([0-9]+))?/?$";s:48:"index.php?rs_center=$matches[1]&page=$matches[2]";s:23:"center/[^/]+/([^/]+)/?$";s:32:"index.php?attachment=$matches[1]";s:33:"center/[^/]+/([^/]+)/trackback/?$";s:37:"index.php?attachment=$matches[1]&tb=1";s:53:"center/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:48:"center/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:48:"center/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$";s:50:"index.php?attachment=$matches[1]&cpage=$matches[2]";s:29:"center/[^/]+/([^/]+)/embed/?$";s:43:"index.php?attachment=$matches[1]&embed=true";s:33:"event/[^/]+/attachment/([^/]+)/?$";s:32:"index.php?attachment=$matches[1]";s:43:"event/[^/]+/attachment/([^/]+)/trackback/?$";s:37:"index.php?attachment=$matches[1]&tb=1";s:63:"event/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:58:"event/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:58:"event/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$";s:50:"index.php?attachment=$matches[1]&cpage=$matches[2]";s:39:"event/[^/]+/attachment/([^/]+)/embed/?$";s:43:"index.php?attachment=$matches[1]&embed=true";s:22:"event/([^/]+)/embed/?$";s:41:"index.php?rs_event=$matches[1]&embed=true";s:26:"event/([^/]+)/trackback/?$";s:35:"index.php?rs_event=$matches[1]&tb=1";s:34:"event/([^/]+)/page/?([0-9]{1,})/?$";s:48:"index.php?rs_event=$matches[1]&paged=$matches[2]";s:41:"event/([^/]+)/comment-page-([0-9]{1,})/?$";s:48:"index.php?rs_event=$matches[1]&cpage=$matches[2]";s:30:"event/([^/]+)(?:/([0-9]+))?/?$";s:47:"index.php?rs_event=$matches[1]&page=$matches[2]";s:22:"event/[^/]+/([^/]+)/?$";s:32:"index.php?attachment=$matches[1]";s:32:"event/[^/]+/([^/]+)/trackback/?$";s:37:"index.php?attachment=$matches[1]&tb=1";s:52:"event/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:47:"event/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:47:"event/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$";s:50:"index.php?attachment=$matches[1]&cpage=$matches[2]";s:28:"event/[^/]+/([^/]+)/embed/?$";s:43:"index.php?attachment=$matches[1]&embed=true";s:37:"resources/[^/]+/attachment/([^/]+)/?$";s:32:"index.php?attachment=$matches[1]";s:47:"resources/[^/]+/attachment/([^/]+)/trackback/?$";s:37:"index.php?attachment=$matches[1]&tb=1";s:67:"resources/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:62:"resources/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:62:"resources/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$";s:50:"index.php?attachment=$matches[1]&cpage=$matches[2]";s:43:"resources/[^/]+/attachment/([^/]+)/embed/?$";s:43:"index.php?attachment=$matches[1]&embed=true";s:26:"resources/([^/]+)/embed/?$";s:41:"index.php?resource=$matches[1]&embed=true";s:30:"resources/([^/]+)/trackback/?$";s:35:"index.php?resource=$matches[1]&tb=1";s:50:"resources/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:47:"index.php?resource=$matches[1]&feed=$matches[2]";s:45:"resources/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:47:"index.php?resource=$matches[1]&feed=$matches[2]";s:38:"resources/([^/]+)/page/?([0-9]{1,})/?$";s:48:"index.php?resource=$matches[1]&paged=$matches[2]";s:45:"resources/([^/]+)/comment-page-([0-9]{1,})/?$";s:48:"index.php?resource=$matches[1]&cpage=$matches[2]";s:34:"resources/([^/]+)(?:/([0-9]+))?/?$";s:47:"index.php?resource=$matches[1]&page=$matches[2]";s:26:"resources/[^/]+/([^/]+)/?$";s:32:"index.php?attachment=$matches[1]";s:36:"resources/[^/]+/([^/]+)/trackback/?$";s:37:"index.php?attachment=$matches[1]&tb=1";s:56:"resources/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:51:"resources/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:51:"resources/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$";s:50:"index.php?attachment=$matches[1]&cpage=$matches[2]";s:32:"resources/[^/]+/([^/]+)/embed/?$";s:43:"index.php?attachment=$matches[1]&embed=true";s:41:"gallery-album/[^/]+/attachment/([^/]+)/?$";s:32:"index.php?attachment=$matches[1]";s:51:"gallery-album/[^/]+/attachment/([^/]+)/trackback/?$";s:37:"index.php?attachment=$matches[1]&tb=1";s:71:"gallery-album/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:66:"gallery-album/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:66:"gallery-album/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$";s:50:"index.php?attachment=$matches[1]&cpage=$matches[2]";s:47:"gallery-album/[^/]+/attachment/([^/]+)/embed/?$";s:43:"index.php?attachment=$matches[1]&embed=true";s:30:"gallery-album/([^/]+)/embed/?$";s:46:"index.php?gallery_album=$matches[1]&embed=true";s:34:"gallery-album/([^/]+)/trackback/?$";s:40:"index.php?gallery_album=$matches[1]&tb=1";s:42:"gallery-album/([^/]+)/page/?([0-9]{1,})/?$";s:53:"index.php?gallery_album=$matches[1]&paged=$matches[2]";s:49:"gallery-album/([^/]+)/comment-page-([0-9]{1,})/?$";s:53:"index.php?gallery_album=$matches[1]&cpage=$matches[2]";s:38:"gallery-album/([^/]+)(?:/([0-9]+))?/?$";s:52:"index.php?gallery_album=$matches[1]&page=$matches[2]";s:30:"gallery-album/[^/]+/([^/]+)/?$";s:32:"index.php?attachment=$matches[1]";s:40:"gallery-album/[^/]+/([^/]+)/trackback/?$";s:37:"index.php?attachment=$matches[1]&tb=1";s:60:"gallery-album/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:55:"gallery-album/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:55:"gallery-album/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$";s:50:"index.php?attachment=$matches[1]&cpage=$matches[2]";s:36:"gallery-album/[^/]+/([^/]+)/embed/?$";s:43:"index.php?attachment=$matches[1]&embed=true";s:58:"activity-category/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:56:"index.php?activity_category=$matches[1]&feed=$matches[2]";s:53:"activity-category/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:56:"index.php?activity_category=$matches[1]&feed=$matches[2]";s:34:"activity-category/([^/]+)/embed/?$";s:50:"index.php?activity_category=$matches[1]&embed=true";s:46:"activity-category/([^/]+)/page/?([0-9]{1,})/?$";s:57:"index.php?activity_category=$matches[1]&paged=$matches[2]";s:28:"activity-category/([^/]+)/?$";s:39:"index.php?activity_category=$matches[1]";s:58:"resource-category/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:56:"index.php?resource_category=$matches[1]&feed=$matches[2]";s:53:"resource-category/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:56:"index.php?resource_category=$matches[1]&feed=$matches[2]";s:34:"resource-category/([^/]+)/embed/?$";s:50:"index.php?resource_category=$matches[1]&embed=true";s:46:"resource-category/([^/]+)/page/?([0-9]{1,})/?$";s:57:"index.php?resource_category=$matches[1]&paged=$matches[2]";s:28:"resource-category/([^/]+)/?$";s:39:"index.php?resource_category=$matches[1]";s:54:"resource-type/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:52:"index.php?resource_type=$matches[1]&feed=$matches[2]";s:49:"resource-type/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:52:"index.php?resource_type=$matches[1]&feed=$matches[2]";s:30:"resource-type/([^/]+)/embed/?$";s:46:"index.php?resource_type=$matches[1]&embed=true";s:42:"resource-type/([^/]+)/page/?([0-9]{1,})/?$";s:53:"index.php?resource_type=$matches[1]&paged=$matches[2]";s:24:"resource-type/([^/]+)/?$";s:35:"index.php?resource_type=$matches[1]";s:57:"gallery-category/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:55:"index.php?gallery_category=$matches[1]&feed=$matches[2]";s:52:"gallery-category/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:55:"index.php?gallery_category=$matches[1]&feed=$matches[2]";s:33:"gallery-category/([^/]+)/embed/?$";s:49:"index.php?gallery_category=$matches[1]&embed=true";s:45:"gallery-category/([^/]+)/page/?([0-9]{1,})/?$";s:56:"index.php?gallery_category=$matches[1]&paged=$matches[2]";s:27:"gallery-category/([^/]+)/?$";s:38:"index.php?gallery_category=$matches[1]";s:53:"faq-category/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:51:"index.php?faq_category=$matches[1]&feed=$matches[2]";s:48:"faq-category/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:51:"index.php?faq_category=$matches[1]&feed=$matches[2]";s:29:"faq-category/([^/]+)/embed/?$";s:45:"index.php?faq_category=$matches[1]&embed=true";s:41:"faq-category/([^/]+)/page/?([0-9]{1,})/?$";s:52:"index.php?faq_category=$matches[1]&paged=$matches[2]";s:23:"faq-category/([^/]+)/?$";s:34:"index.php?faq_category=$matches[1]";s:46:"event/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:47:"index.php?rs_event=$matches[1]&feed=$matches[2]";s:41:"event/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:47:"index.php?rs_event=$matches[1]&feed=$matches[2]";s:37:"rs_member/[^/]+/attachment/([^/]+)/?$";s:32:"index.php?attachment=$matches[1]";s:47:"rs_member/[^/]+/attachment/([^/]+)/trackback/?$";s:37:"index.php?attachment=$matches[1]&tb=1";s:67:"rs_member/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:62:"rs_member/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:62:"rs_member/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$";s:50:"index.php?attachment=$matches[1]&cpage=$matches[2]";s:43:"rs_member/[^/]+/attachment/([^/]+)/embed/?$";s:43:"index.php?attachment=$matches[1]&embed=true";s:26:"rs_member/([^/]+)/embed/?$";s:42:"index.php?rs_member=$matches[1]&embed=true";s:30:"rs_member/([^/]+)/trackback/?$";s:36:"index.php?rs_member=$matches[1]&tb=1";s:38:"rs_member/([^/]+)/page/?([0-9]{1,})/?$";s:49:"index.php?rs_member=$matches[1]&paged=$matches[2]";s:45:"rs_member/([^/]+)/comment-page-([0-9]{1,})/?$";s:49:"index.php?rs_member=$matches[1]&cpage=$matches[2]";s:34:"rs_member/([^/]+)(?:/([0-9]+))?/?$";s:48:"index.php?rs_member=$matches[1]&page=$matches[2]";s:26:"rs_member/[^/]+/([^/]+)/?$";s:32:"index.php?attachment=$matches[1]";s:36:"rs_member/[^/]+/([^/]+)/trackback/?$";s:37:"index.php?attachment=$matches[1]&tb=1";s:56:"rs_member/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:51:"rs_member/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:51:"rs_member/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$";s:50:"index.php?attachment=$matches[1]&cpage=$matches[2]";s:32:"rs_member/[^/]+/([^/]+)/embed/?$";s:43:"index.php?attachment=$matches[1]&embed=true";s:44:"rs_gallery_album/[^/]+/attachment/([^/]+)/?$";s:32:"index.php?attachment=$matches[1]";s:54:"rs_gallery_album/[^/]+/attachment/([^/]+)/trackback/?$";s:37:"index.php?attachment=$matches[1]&tb=1";s:74:"rs_gallery_album/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:69:"rs_gallery_album/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:69:"rs_gallery_album/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$";s:50:"index.php?attachment=$matches[1]&cpage=$matches[2]";s:50:"rs_gallery_album/[^/]+/attachment/([^/]+)/embed/?$";s:43:"index.php?attachment=$matches[1]&embed=true";s:33:"rs_gallery_album/([^/]+)/embed/?$";s:49:"index.php?rs_gallery_album=$matches[1]&embed=true";s:37:"rs_gallery_album/([^/]+)/trackback/?$";s:43:"index.php?rs_gallery_album=$matches[1]&tb=1";s:45:"rs_gallery_album/([^/]+)/page/?([0-9]{1,})/?$";s:56:"index.php?rs_gallery_album=$matches[1]&paged=$matches[2]";s:52:"rs_gallery_album/([^/]+)/comment-page-([0-9]{1,})/?$";s:56:"index.php?rs_gallery_album=$matches[1]&cpage=$matches[2]";s:41:"rs_gallery_album/([^/]+)(?:/([0-9]+))?/?$";s:55:"index.php?rs_gallery_album=$matches[1]&page=$matches[2]";s:33:"rs_gallery_album/[^/]+/([^/]+)/?$";s:32:"index.php?attachment=$matches[1]";s:43:"rs_gallery_album/[^/]+/([^/]+)/trackback/?$";s:37:"index.php?attachment=$matches[1]&tb=1";s:63:"rs_gallery_album/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:58:"rs_gallery_album/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:58:"rs_gallery_album/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$";s:50:"index.php?attachment=$matches[1]&cpage=$matches[2]";s:39:"rs_gallery_album/[^/]+/([^/]+)/embed/?$";s:43:"index.php?attachment=$matches[1]&embed=true";s:12:"robots\\.txt$";s:18:"index.php?robots=1";s:13:"favicon\\.ico$";s:19:"index.php?favicon=1";s:12:"sitemap\\.xml";s:23:"index.php?sitemap=index";s:48:".*wp-(atom|rdf|rss|rss2|feed|commentsrss2)\\.php$";s:18:"index.php?feed=old";s:20:".*wp-app\\.php(/.*)?$";s:19:"index.php?error=403";s:18:".*wp-register.php$";s:23:"index.php?register=true";s:32:"feed/(feed|rdf|rss|rss2|atom)/?$";s:27:"index.php?&feed=$matches[1]";s:27:"(feed|rdf|rss|rss2|atom)/?$";s:27:"index.php?&feed=$matches[1]";s:8:"embed/?$";s:21:"index.php?&embed=true";s:20:"page/?([0-9]{1,})/?$";s:28:"index.php?&paged=$matches[1]";s:27:"comment-page-([0-9]{1,})/?$";s:39:"index.php?&page_id=88&cpage=$matches[1]";s:41:"comments/feed/(feed|rdf|rss|rss2|atom)/?$";s:42:"index.php?&feed=$matches[1]&withcomments=1";s:36:"comments/(feed|rdf|rss|rss2|atom)/?$";s:42:"index.php?&feed=$matches[1]&withcomments=1";s:17:"comments/embed/?$";s:21:"index.php?&embed=true";s:44:"search/(.+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:40:"index.php?s=$matches[1]&feed=$matches[2]";s:39:"search/(.+)/(feed|rdf|rss|rss2|atom)/?$";s:40:"index.php?s=$matches[1]&feed=$matches[2]";s:20:"search/(.+)/embed/?$";s:34:"index.php?s=$matches[1]&embed=true";s:32:"search/(.+)/page/?([0-9]{1,})/?$";s:41:"index.php?s=$matches[1]&paged=$matches[2]";s:14:"search/(.+)/?$";s:23:"index.php?s=$matches[1]";s:47:"author/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:50:"index.php?author_name=$matches[1]&feed=$matches[2]";s:42:"author/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:50:"index.php?author_name=$matches[1]&feed=$matches[2]";s:23:"author/([^/]+)/embed/?$";s:44:"index.php?author_name=$matches[1]&embed=true";s:35:"author/([^/]+)/page/?([0-9]{1,})/?$";s:51:"index.php?author_name=$matches[1]&paged=$matches[2]";s:17:"author/([^/]+)/?$";s:33:"index.php?author_name=$matches[1]";s:69:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$";s:80:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]";s:64:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$";s:80:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]";s:45:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/embed/?$";s:74:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&embed=true";s:57:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/page/?([0-9]{1,})/?$";s:81:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&paged=$matches[4]";s:39:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/?$";s:63:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]";s:56:"([0-9]{4})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$";s:64:"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]";s:51:"([0-9]{4})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$";s:64:"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]";s:32:"([0-9]{4})/([0-9]{1,2})/embed/?$";s:58:"index.php?year=$matches[1]&monthnum=$matches[2]&embed=true";s:44:"([0-9]{4})/([0-9]{1,2})/page/?([0-9]{1,})/?$";s:65:"index.php?year=$matches[1]&monthnum=$matches[2]&paged=$matches[3]";s:26:"([0-9]{4})/([0-9]{1,2})/?$";s:47:"index.php?year=$matches[1]&monthnum=$matches[2]";s:43:"([0-9]{4})/feed/(feed|rdf|rss|rss2|atom)/?$";s:43:"index.php?year=$matches[1]&feed=$matches[2]";s:38:"([0-9]{4})/(feed|rdf|rss|rss2|atom)/?$";s:43:"index.php?year=$matches[1]&feed=$matches[2]";s:19:"([0-9]{4})/embed/?$";s:37:"index.php?year=$matches[1]&embed=true";s:31:"([0-9]{4})/page/?([0-9]{1,})/?$";s:44:"index.php?year=$matches[1]&paged=$matches[2]";s:13:"([0-9]{4})/?$";s:26:"index.php?year=$matches[1]";s:58:"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/?$";s:32:"index.php?attachment=$matches[1]";s:68:"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/trackback/?$";s:37:"index.php?attachment=$matches[1]&tb=1";s:88:"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:83:"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:83:"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$";s:50:"index.php?attachment=$matches[1]&cpage=$matches[2]";s:64:"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/embed/?$";s:43:"index.php?attachment=$matches[1]&embed=true";s:53:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/embed/?$";s:91:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&embed=true";s:57:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/trackback/?$";s:85:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&tb=1";s:77:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:97:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&feed=$matches[5]";s:72:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:97:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&feed=$matches[5]";s:65:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/page/?([0-9]{1,})/?$";s:98:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&paged=$matches[5]";s:72:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/comment-page-([0-9]{1,})/?$";s:98:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&cpage=$matches[5]";s:61:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)(?:/([0-9]+))?/?$";s:97:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&page=$matches[5]";s:47:"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/?$";s:32:"index.php?attachment=$matches[1]";s:57:"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/trackback/?$";s:37:"index.php?attachment=$matches[1]&tb=1";s:77:"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:72:"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:72:"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$";s:50:"index.php?attachment=$matches[1]&cpage=$matches[2]";s:53:"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/embed/?$";s:43:"index.php?attachment=$matches[1]&embed=true";s:64:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/comment-page-([0-9]{1,})/?$";s:81:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&cpage=$matches[4]";s:51:"([0-9]{4})/([0-9]{1,2})/comment-page-([0-9]{1,})/?$";s:65:"index.php?year=$matches[1]&monthnum=$matches[2]&cpage=$matches[3]";s:38:"([0-9]{4})/comment-page-([0-9]{1,})/?$";s:44:"index.php?year=$matches[1]&cpage=$matches[2]";s:27:".?.+?/attachment/([^/]+)/?$";s:32:"index.php?attachment=$matches[1]";s:37:".?.+?/attachment/([^/]+)/trackback/?$";s:37:"index.php?attachment=$matches[1]&tb=1";s:57:".?.+?/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:52:".?.+?/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:52:".?.+?/attachment/([^/]+)/comment-page-([0-9]{1,})/?$";s:50:"index.php?attachment=$matches[1]&cpage=$matches[2]";s:33:".?.+?/attachment/([^/]+)/embed/?$";s:43:"index.php?attachment=$matches[1]&embed=true";s:16:"(.?.+?)/embed/?$";s:41:"index.php?pagename=$matches[1]&embed=true";s:20:"(.?.+?)/trackback/?$";s:35:"index.php?pagename=$matches[1]&tb=1";s:40:"(.?.+?)/feed/(feed|rdf|rss|rss2|atom)/?$";s:47:"index.php?pagename=$matches[1]&feed=$matches[2]";s:35:"(.?.+?)/(feed|rdf|rss|rss2|atom)/?$";s:47:"index.php?pagename=$matches[1]&feed=$matches[2]";s:28:"(.?.+?)/page/?([0-9]{1,})/?$";s:48:"index.php?pagename=$matches[1]&paged=$matches[2]";s:35:"(.?.+?)/comment-page-([0-9]{1,})/?$";s:48:"index.php?pagename=$matches[1]&cpage=$matches[2]";s:24:"(.?.+?)(?:/([0-9]+))?/?$";s:47:"index.php?pagename=$matches[1]&page=$matches[2]";}','on');
INSERT INTO `wp_options` VALUES (30,'hack_file',0,'on');
INSERT INTO `wp_options` VALUES (31,'blog_charset','UTF-8','on');
INSERT INTO `wp_options` VALUES (32,'moderation_keys','','off');
INSERT INTO `wp_options` VALUES (33,'active_plugins','a:3:{i:0;s:30:"advanced-custom-fields/acf.php";i:1;s:41:"rashtrotthana-core/rashtrotthana-core.php";i:2;s:57:"rashtrotthana-registration/rashtrotthana-registration.php";}','on');
INSERT INTO `wp_options` VALUES (34,'category_base','','on');
INSERT INTO `wp_options` VALUES (35,'ping_sites','https://rpc.pingomatic.com/','on');
INSERT INTO `wp_options` VALUES (36,'comment_max_links',2,'on');
INSERT INTO `wp_options` VALUES (37,'gmt_offset',0,'on');
INSERT INTO `wp_options` VALUES (38,'default_email_category',1,'on');
INSERT INTO `wp_options` VALUES (39,'recently_edited','','off');
INSERT INTO `wp_options` VALUES (40,'template','rashtrotthana','on');
INSERT INTO `wp_options` VALUES (41,'stylesheet','rashtrotthana','on');
INSERT INTO `wp_options` VALUES (42,'comment_registration',0,'on');
INSERT INTO `wp_options` VALUES (43,'html_type','text/html','on');
INSERT INTO `wp_options` VALUES (44,'use_trackback',0,'on');
INSERT INTO `wp_options` VALUES (45,'default_role','subscriber','on');
INSERT INTO `wp_options` VALUES (46,'db_version',61833,'on');
INSERT INTO `wp_options` VALUES (47,'uploads_use_yearmonth_folders',1,'on');
INSERT INTO `wp_options` VALUES (48,'upload_path','','on');
INSERT INTO `wp_options` VALUES (49,'blog_public',1,'on');
INSERT INTO `wp_options` VALUES (50,'default_link_category',2,'on');
INSERT INTO `wp_options` VALUES (51,'show_on_front','page','on');
INSERT INTO `wp_options` VALUES (52,'tag_base','','on');
INSERT INTO `wp_options` VALUES (53,'show_avatars',1,'on');
INSERT INTO `wp_options` VALUES (54,'avatar_rating','G','on');
INSERT INTO `wp_options` VALUES (55,'upload_url_path','','on');
INSERT INTO `wp_options` VALUES (56,'thumbnail_size_w',150,'on');
INSERT INTO `wp_options` VALUES (57,'thumbnail_size_h',150,'on');
INSERT INTO `wp_options` VALUES (58,'thumbnail_crop',1,'on');
INSERT INTO `wp_options` VALUES (59,'medium_size_w',300,'on');
INSERT INTO `wp_options` VALUES (60,'medium_size_h',300,'on');
INSERT INTO `wp_options` VALUES (61,'avatar_default','mystery','on');
INSERT INTO `wp_options` VALUES (62,'large_size_w',1024,'on');
INSERT INTO `wp_options` VALUES (63,'large_size_h',1024,'on');
INSERT INTO `wp_options` VALUES (64,'image_default_link_type','none','on');
INSERT INTO `wp_options` VALUES (65,'image_default_size','','on');
INSERT INTO `wp_options` VALUES (66,'image_default_align','','on');
INSERT INTO `wp_options` VALUES (67,'close_comments_for_old_posts',0,'on');
INSERT INTO `wp_options` VALUES (68,'close_comments_days_old',14,'on');
INSERT INTO `wp_options` VALUES (69,'thread_comments',1,'on');
INSERT INTO `wp_options` VALUES (70,'thread_comments_depth',5,'on');
INSERT INTO `wp_options` VALUES (71,'page_comments',0,'on');
INSERT INTO `wp_options` VALUES (72,'comments_per_page',50,'on');
INSERT INTO `wp_options` VALUES (73,'default_comments_page','newest','on');
INSERT INTO `wp_options` VALUES (74,'comment_order','asc','on');
INSERT INTO `wp_options` VALUES (75,'sticky_posts','a:0:{}','on');
INSERT INTO `wp_options` VALUES (76,'widget_categories','a:0:{}','on');
INSERT INTO `wp_options` VALUES (77,'widget_text','a:0:{}','on');
INSERT INTO `wp_options` VALUES (78,'widget_rss','a:0:{}','on');
INSERT INTO `wp_options` VALUES (79,'uninstall_plugins','a:0:{}','off');
INSERT INTO `wp_options` VALUES (80,'timezone_string','','on');
INSERT INTO `wp_options` VALUES (81,'page_for_posts',0,'on');
INSERT INTO `wp_options` VALUES (82,'page_on_front',88,'on');
INSERT INTO `wp_options` VALUES (83,'default_post_format',0,'on');
INSERT INTO `wp_options` VALUES (84,'link_manager_enabled',0,'on');
INSERT INTO `wp_options` VALUES (85,'finished_splitting_shared_terms',1,'on');
INSERT INTO `wp_options` VALUES (86,'site_icon',0,'on');
INSERT INTO `wp_options` VALUES (87,'medium_large_size_w',768,'on');
INSERT INTO `wp_options` VALUES (88,'medium_large_size_h',0,'on');
INSERT INTO `wp_options` VALUES (89,'wp_page_for_privacy_policy',3,'on');
INSERT INTO `wp_options` VALUES (90,'show_comments_cookies_opt_in',1,'on');
INSERT INTO `wp_options` VALUES (91,'admin_email_lifespan',1803481055,'on');
INSERT INTO `wp_options` VALUES (92,'disallowed_keys','','off');
INSERT INTO `wp_options` VALUES (93,'comment_previously_approved',1,'on');
INSERT INTO `wp_options` VALUES (94,'auto_plugin_theme_update_emails','a:0:{}','off');
INSERT INTO `wp_options` VALUES (95,'auto_update_core_dev','enabled','on');
INSERT INTO `wp_options` VALUES (96,'auto_update_core_minor','enabled','on');
INSERT INTO `wp_options` VALUES (97,'auto_update_core_major','enabled','on');
INSERT INTO `wp_options` VALUES (98,'wp_force_deactivated_plugins','a:0:{}','on');
INSERT INTO `wp_options` VALUES (99,'wp_attachment_pages_enabled',0,'on');
INSERT INTO `wp_options` VALUES (100,'wp_notes_notify',1,'on');
INSERT INTO `wp_options` VALUES (101,'initial_db_version',61833,'on');
INSERT INTO `wp_options` VALUES (102,'wp_user_roles','a:6:{s:13:"administrator";a:2:{s:4:"name";s:13:"Administrator";s:12:"capabilities";a:62:{s:13:"switch_themes";b:1;s:11:"edit_themes";b:1;s:16:"activate_plugins";b:1;s:12:"edit_plugins";b:1;s:10:"edit_users";b:1;s:10:"edit_files";b:1;s:14:"manage_options";b:1;s:17:"moderate_comments";b:1;s:17:"manage_categories";b:1;s:12:"manage_links";b:1;s:12:"upload_files";b:1;s:6:"import";b:1;s:15:"unfiltered_html";b:1;s:10:"edit_posts";b:1;s:17:"edit_others_posts";b:1;s:20:"edit_published_posts";b:1;s:13:"publish_posts";b:1;s:10:"edit_pages";b:1;s:4:"read";b:1;s:8:"level_10";b:1;s:7:"level_9";b:1;s:7:"level_8";b:1;s:7:"level_7";b:1;s:7:"level_6";b:1;s:7:"level_5";b:1;s:7:"level_4";b:1;s:7:"level_3";b:1;s:7:"level_2";b:1;s:7:"level_1";b:1;s:7:"level_0";b:1;s:17:"edit_others_pages";b:1;s:20:"edit_published_pages";b:1;s:13:"publish_pages";b:1;s:12:"delete_pages";b:1;s:19:"delete_others_pages";b:1;s:22:"delete_published_pages";b:1;s:12:"delete_posts";b:1;s:19:"delete_others_posts";b:1;s:22:"delete_published_posts";b:1;s:20:"delete_private_posts";b:1;s:18:"edit_private_posts";b:1;s:18:"read_private_posts";b:1;s:20:"delete_private_pages";b:1;s:18:"edit_private_pages";b:1;s:18:"read_private_pages";b:1;s:12:"delete_users";b:1;s:12:"create_users";b:1;s:17:"unfiltered_upload";b:1;s:14:"edit_dashboard";b:1;s:14:"update_plugins";b:1;s:14:"delete_plugins";b:1;s:15:"install_plugins";b:1;s:13:"update_themes";b:1;s:14:"install_themes";b:1;s:11:"update_core";b:1;s:10:"list_users";b:1;s:12:"remove_users";b:1;s:13:"promote_users";b:1;s:18:"edit_theme_options";b:1;s:13:"delete_themes";b:1;s:6:"export";b:1;s:23:"manage_ry_registrations";b:1;}}s:6:"editor";a:2:{s:4:"name";s:6:"Editor";s:12:"capabilities";a:34:{s:17:"moderate_comments";b:1;s:17:"manage_categories";b:1;s:12:"manage_links";b:1;s:12:"upload_files";b:1;s:15:"unfiltered_html";b:1;s:10:"edit_posts";b:1;s:17:"edit_others_posts";b:1;s:20:"edit_published_posts";b:1;s:13:"publish_posts";b:1;s:10:"edit_pages";b:1;s:4:"read";b:1;s:7:"level_7";b:1;s:7:"level_6";b:1;s:7:"level_5";b:1;s:7:"level_4";b:1;s:7:"level_3";b:1;s:7:"level_2";b:1;s:7:"level_1";b:1;s:7:"level_0";b:1;s:17:"edit_others_pages";b:1;s:20:"edit_published_pages";b:1;s:13:"publish_pages";b:1;s:12:"delete_pages";b:1;s:19:"delete_others_pages";b:1;s:22:"delete_published_pages";b:1;s:12:"delete_posts";b:1;s:19:"delete_others_posts";b:1;s:22:"delete_published_posts";b:1;s:20:"delete_private_posts";b:1;s:18:"edit_private_posts";b:1;s:18:"read_private_posts";b:1;s:20:"delete_private_pages";b:1;s:18:"edit_private_pages";b:1;s:18:"read_private_pages";b:1;}}s:6:"author";a:2:{s:4:"name";s:6:"Author";s:12:"capabilities";a:10:{s:12:"upload_files";b:1;s:10:"edit_posts";b:1;s:20:"edit_published_posts";b:1;s:13:"publish_posts";b:1;s:4:"read";b:1;s:7:"level_2";b:1;s:7:"level_1";b:1;s:7:"level_0";b:1;s:12:"delete_posts";b:1;s:22:"delete_published_posts";b:1;}}s:11:"contributor";a:2:{s:4:"name";s:11:"Contributor";s:12:"capabilities";a:5:{s:10:"edit_posts";b:1;s:4:"read";b:1;s:7:"level_1";b:1;s:7:"level_0";b:1;s:12:"delete_posts";b:1;}}s:10:"subscriber";a:2:{s:4:"name";s:10:"Subscriber";s:12:"capabilities";a:2:{s:4:"read";b:1;s:7:"level_0";b:1;}}s:20:"registration_manager";a:2:{s:4:"name";s:20:"Registration Manager";s:12:"capabilities";a:2:{s:4:"read";b:1;s:23:"manage_ry_registrations";b:1;}}}','on');
INSERT INTO `wp_options` VALUES (103,'fresh_site',0,'off');
INSERT INTO `wp_options` VALUES (104,'user_count',1,'off');
INSERT INTO `wp_options` VALUES (105,'widget_block','a:6:{i:2;a:1:{s:7:"content";s:19:"<!-- wp:search /-->";}i:3;a:1:{s:7:"content";s:154:"<!-- wp:group --><div class="wp-block-group"><!-- wp:heading --><h2>Recent Posts</h2><!-- /wp:heading --><!-- wp:latest-posts /--></div><!-- /wp:group -->";}i:4;a:1:{s:7:"content";s:227:"<!-- wp:group --><div class="wp-block-group"><!-- wp:heading --><h2>Recent Comments</h2><!-- /wp:heading --><!-- wp:latest-comments {"displayAvatar":false,"displayDate":false,"displayExcerpt":false} /--></div><!-- /wp:group -->";}i:5;a:1:{s:7:"content";s:146:"<!-- wp:group --><div class="wp-block-group"><!-- wp:heading --><h2>Archives</h2><!-- /wp:heading --><!-- wp:archives /--></div><!-- /wp:group -->";}i:6;a:1:{s:7:"content";s:150:"<!-- wp:group --><div class="wp-block-group"><!-- wp:heading --><h2>Categories</h2><!-- /wp:heading --><!-- wp:categories /--></div><!-- /wp:group -->";}s:12:"_multiwidget";i:1;}','auto');
INSERT INTO `wp_options` VALUES (106,'sidebars_widgets','a:2:{s:19:"wp_inactive_widgets";a:5:{i:0;s:7:"block-2";i:1;s:7:"block-3";i:2;s:7:"block-4";i:3;s:7:"block-5";i:4;s:7:"block-6";}s:13:"array_version";i:3;}','auto');
INSERT INTO `wp_options` VALUES (107,'cron','a:11:{i:1791129461;a:1:{s:34:"wp_privacy_delete_old_export_files";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:6:"hourly";s:4:"args";a:0:{}s:8:"interval";i:3600;}}}i:1791168424;a:1:{s:21:"wp_update_user_counts";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:10:"twicedaily";s:4:"args";a:0:{}s:8:"interval";i:43200;}}}i:1791169061;a:3:{s:16:"wp_version_check";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:10:"twicedaily";s:4:"args";a:0:{}s:8:"interval";i:43200;}}s:17:"wp_update_plugins";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:10:"twicedaily";s:4:"args";a:0:{}s:8:"interval";i:43200;}}s:16:"wp_update_themes";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:10:"twicedaily";s:4:"args";a:0:{}s:8:"interval";i:43200;}}}i:1791211624;a:2:{s:19:"wp_scheduled_delete";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:5:"daily";s:4:"args";a:0:{}s:8:"interval";i:86400;}}s:25:"delete_expired_transients";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:5:"daily";s:4:"args";a:0:{}s:8:"interval";i:86400;}}}i:1791211626;a:1:{s:30:"wp_scheduled_auto_draft_delete";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:5:"daily";s:4:"args";a:0:{}s:8:"interval";i:86400;}}}i:1791212117;a:1:{s:27:"acf_update_site_health_data";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:5:"daily";s:4:"args";a:0:{}s:8:"interval";i:86400;}}}i:1791212260;a:1:{s:32:"recovery_mode_clean_expired_keys";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:5:"daily";s:4:"args";a:0:{}s:8:"interval";i:86400;}}}i:1791212261;a:1:{s:41:"wp_privacy_personal_data_cleanup_requests";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:5:"daily";s:4:"args";a:0:{}s:8:"interval";i:86400;}}}i:1791298476;a:1:{s:30:"wp_delete_temp_updater_backups";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:6:"weekly";s:4:"args";a:0:{}s:8:"interval";i:604800;}}}i:1791644260;a:1:{s:30:"wp_site_health_scheduled_check";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:6:"weekly";s:4:"args";a:0:{}s:8:"interval";i:604800;}}}s:7:"version";i:2;}','on');
INSERT INTO `wp_options` VALUES (108,'widget_pages','a:1:{s:12:"_multiwidget";i:1;}','auto');
INSERT INTO `wp_options` VALUES (109,'widget_calendar','a:1:{s:12:"_multiwidget";i:1;}','auto');
INSERT INTO `wp_options` VALUES (110,'widget_archives','a:1:{s:12:"_multiwidget";i:1;}','auto');
INSERT INTO `wp_options` VALUES (111,'widget_media_audio','a:1:{s:12:"_multiwidget";i:1;}','auto');
INSERT INTO `wp_options` VALUES (112,'widget_media_image','a:1:{s:12:"_multiwidget";i:1;}','auto');
INSERT INTO `wp_options` VALUES (113,'widget_media_gallery','a:1:{s:12:"_multiwidget";i:1;}','auto');
INSERT INTO `wp_options` VALUES (114,'widget_media_video','a:1:{s:12:"_multiwidget";i:1;}','auto');
INSERT INTO `wp_options` VALUES (115,'widget_meta','a:1:{s:12:"_multiwidget";i:1;}','auto');
INSERT INTO `wp_options` VALUES (116,'widget_search','a:1:{s:12:"_multiwidget";i:1;}','auto');
INSERT INTO `wp_options` VALUES (117,'widget_recent-posts','a:1:{s:12:"_multiwidget";i:1;}','auto');
INSERT INTO `wp_options` VALUES (118,'widget_recent-comments','a:1:{s:12:"_multiwidget";i:1;}','auto');
INSERT INTO `wp_options` VALUES (119,'widget_tag_cloud','a:1:{s:12:"_multiwidget";i:1;}','auto');
INSERT INTO `wp_options` VALUES (120,'widget_nav_menu','a:1:{s:12:"_multiwidget";i:1;}','auto');
INSERT INTO `wp_options` VALUES (121,'widget_custom_html','a:1:{s:12:"_multiwidget";i:1;}','auto');
INSERT INTO `wp_options` VALUES (122,'_transient_wp_core_block_css_files','a:2:{s:7:"version";s:3:"7.1";s:5:"files";a:624:{i:0;s:31:"accordion-heading/style-rtl.css";i:1;s:35:"accordion-heading/style-rtl.min.css";i:2;s:27:"accordion-heading/style.css";i:3;s:31:"accordion-heading/style.min.css";i:4;s:28:"accordion-item/style-rtl.css";i:5;s:32:"accordion-item/style-rtl.min.css";i:6;s:24:"accordion-item/style.css";i:7;s:28:"accordion-item/style.min.css";i:8;s:29:"accordion-panel/style-rtl.css";i:9;s:33:"accordion-panel/style-rtl.min.css";i:10;s:25:"accordion-panel/style.css";i:11;s:29:"accordion-panel/style.min.css";i:12;s:23:"accordion/style-rtl.css";i:13;s:27:"accordion/style-rtl.min.css";i:14;s:19:"accordion/style.css";i:15;s:23:"accordion/style.min.css";i:16;s:22:"archives/style-rtl.css";i:17;s:26:"archives/style-rtl.min.css";i:18;s:18:"archives/style.css";i:19;s:22:"archives/style.min.css";i:20;s:20:"audio/editor-rtl.css";i:21;s:24:"audio/editor-rtl.min.css";i:22;s:16:"audio/editor.css";i:23;s:20:"audio/editor.min.css";i:24;s:19:"audio/style-rtl.css";i:25;s:23:"audio/style-rtl.min.css";i:26;s:15:"audio/style.css";i:27;s:19:"audio/style.min.css";i:28;s:19:"audio/theme-rtl.css";i:29;s:23:"audio/theme-rtl.min.css";i:30;s:15:"audio/theme.css";i:31;s:19:"audio/theme.min.css";i:32;s:21:"avatar/editor-rtl.css";i:33;s:25:"avatar/editor-rtl.min.css";i:34;s:17:"avatar/editor.css";i:35;s:21:"avatar/editor.min.css";i:36;s:20:"avatar/style-rtl.css";i:37;s:24:"avatar/style-rtl.min.css";i:38;s:16:"avatar/style.css";i:39;s:20:"avatar/style.min.css";i:40;s:25:"breadcrumbs/style-rtl.css";i:41;s:29:"breadcrumbs/style-rtl.min.css";i:42;s:21:"breadcrumbs/style.css";i:43;s:25:"breadcrumbs/style.min.css";i:44;s:21:"button/editor-rtl.css";i:45;s:25:"button/editor-rtl.min.css";i:46;s:17:"button/editor.css";i:47;s:21:"button/editor.min.css";i:48;s:20:"button/style-rtl.css";i:49;s:24:"button/style-rtl.min.css";i:50;s:16:"button/style.css";i:51;s:20:"button/style.min.css";i:52;s:22:"buttons/editor-rtl.css";i:53;s:26:"buttons/editor-rtl.min.css";i:54;s:18:"buttons/editor.css";i:55;s:22:"buttons/editor.min.css";i:56;s:21:"buttons/style-rtl.css";i:57;s:25:"buttons/style-rtl.min.css";i:58;s:17:"buttons/style.css";i:59;s:21:"buttons/style.min.css";i:60;s:22:"calendar/style-rtl.css";i:61;s:26:"calendar/style-rtl.min.css";i:62;s:18:"calendar/style.css";i:63;s:22:"calendar/style.min.css";i:64;s:25:"categories/editor-rtl.css";i:65;s:29:"categories/editor-rtl.min.css";i:66;s:21:"categories/editor.css";i:67;s:25:"categories/editor.min.css";i:68;s:24:"categories/style-rtl.css";i:69;s:28:"categories/style-rtl.min.css";i:70;s:20:"categories/style.css";i:71;s:24:"categories/style.min.css";i:72;s:19:"code/editor-rtl.css";i:73;s:23:"code/editor-rtl.min.css";i:74;s:15:"code/editor.css";i:75;s:19:"code/editor.min.css";i:76;s:18:"code/style-rtl.css";i:77;s:22:"code/style-rtl.min.css";i:78;s:14:"code/style.css";i:79;s:18:"code/style.min.css";i:80;s:18:"code/theme-rtl.css";i:81;s:22:"code/theme-rtl.min.css";i:82;s:14:"code/theme.css";i:83;s:18:"code/theme.min.css";i:84;s:22:"columns/editor-rtl.css";i:85;s:26:"columns/editor-rtl.min.css";i:86;s:18:"columns/editor.css";i:87;s:22:"columns/editor.min.css";i:88;s:21:"columns/style-rtl.css";i:89;s:25:"columns/style-rtl.min.css";i:90;s:17:"columns/style.css";i:91;s:21:"columns/style.min.css";i:92;s:33:"comment-author-name/style-rtl.css";i:93;s:37:"comment-author-name/style-rtl.min.css";i:94;s:29:"comment-author-name/style.css";i:95;s:33:"comment-author-name/style.min.css";i:96;s:29:"comment-content/style-rtl.css";i:97;s:33:"comment-content/style-rtl.min.css";i:98;s:25:"comment-content/style.css";i:99;s:29:"comment-content/style.min.css";i:100;s:26:"comment-date/style-rtl.css";i:101;s:30:"comment-date/style-rtl.min.css";i:102;s:22:"comment-date/style.css";i:103;s:26:"comment-date/style.min.css";i:104;s:31:"comment-edit-link/style-rtl.css";i:105;s:35:"comment-edit-link/style-rtl.min.css";i:106;s:27:"comment-edit-link/style.css";i:107;s:31:"comment-edit-link/style.min.css";i:108;s:32:"comment-reply-link/style-rtl.css";i:109;s:36:"comment-reply-link/style-rtl.min.css";i:110;s:28:"comment-reply-link/style.css";i:111;s:32:"comment-reply-link/style.min.css";i:112;s:30:"comment-template/style-rtl.css";i:113;s:34:"comment-template/style-rtl.min.css";i:114;s:26:"comment-template/style.css";i:115;s:30:"comment-template/style.min.css";i:116;s:42:"comments-pagination-numbers/editor-rtl.css";i:117;s:46:"comments-pagination-numbers/editor-rtl.min.css";i:118;s:38:"comments-pagination-numbers/editor.css";i:119;s:42:"comments-pagination-numbers/editor.min.css";i:120;s:34:"comments-pagination/editor-rtl.css";i:121;s:38:"comments-pagination/editor-rtl.min.css";i:122;s:30:"comments-pagination/editor.css";i:123;s:34:"comments-pagination/editor.min.css";i:124;s:33:"comments-pagination/style-rtl.css";i:125;s:37:"comments-pagination/style-rtl.min.css";i:126;s:29:"comments-pagination/style.css";i:127;s:33:"comments-pagination/style.min.css";i:128;s:29:"comments-title/editor-rtl.css";i:129;s:33:"comments-title/editor-rtl.min.css";i:130;s:25:"comments-title/editor.css";i:131;s:29:"comments-title/editor.min.css";i:132;s:23:"comments/editor-rtl.css";i:133;s:27:"comments/editor-rtl.min.css";i:134;s:19:"comments/editor.css";i:135;s:23:"comments/editor.min.css";i:136;s:22:"comments/style-rtl.css";i:137;s:26:"comments/style-rtl.min.css";i:138;s:18:"comments/style.css";i:139;s:22:"comments/style.min.css";i:140;s:20:"cover/editor-rtl.css";i:141;s:24:"cover/editor-rtl.min.css";i:142;s:16:"cover/editor.css";i:143;s:20:"cover/editor.min.css";i:144;s:19:"cover/style-rtl.css";i:145;s:23:"cover/style-rtl.min.css";i:146;s:15:"cover/style.css";i:147;s:19:"cover/style.min.css";i:148;s:22:"details/editor-rtl.css";i:149;s:26:"details/editor-rtl.min.css";i:150;s:18:"details/editor.css";i:151;s:22:"details/editor.min.css";i:152;s:21:"details/style-rtl.css";i:153;s:25:"details/style-rtl.min.css";i:154;s:17:"details/style.css";i:155;s:21:"details/style.min.css";i:156;s:20:"embed/editor-rtl.css";i:157;s:24:"embed/editor-rtl.min.css";i:158;s:16:"embed/editor.css";i:159;s:20:"embed/editor.min.css";i:160;s:19:"embed/style-rtl.css";i:161;s:23:"embed/style-rtl.min.css";i:162;s:15:"embed/style.css";i:163;s:19:"embed/style.min.css";i:164;s:19:"embed/theme-rtl.css";i:165;s:23:"embed/theme-rtl.min.css";i:166;s:15:"embed/theme.css";i:167;s:19:"embed/theme.min.css";i:168;s:19:"file/editor-rtl.css";i:169;s:23:"file/editor-rtl.min.css";i:170;s:15:"file/editor.css";i:171;s:19:"file/editor.min.css";i:172;s:18:"file/style-rtl.css";i:173;s:22:"file/style-rtl.min.css";i:174;s:14:"file/style.css";i:175;s:18:"file/style.min.css";i:176;s:23:"footnotes/style-rtl.css";i:177;s:27:"footnotes/style-rtl.min.css";i:178;s:19:"footnotes/style.css";i:179;s:23:"footnotes/style.min.css";i:180;s:23:"freeform/editor-rtl.css";i:181;s:27:"freeform/editor-rtl.min.css";i:182;s:19:"freeform/editor.css";i:183;s:23:"freeform/editor.min.css";i:184;s:22:"gallery/editor-rtl.css";i:185;s:26:"gallery/editor-rtl.min.css";i:186;s:18:"gallery/editor.css";i:187;s:22:"gallery/editor.min.css";i:188;s:21:"gallery/style-rtl.css";i:189;s:25:"gallery/style-rtl.min.css";i:190;s:17:"gallery/style.css";i:191;s:21:"gallery/style.min.css";i:192;s:21:"gallery/theme-rtl.css";i:193;s:25:"gallery/theme-rtl.min.css";i:194;s:17:"gallery/theme.css";i:195;s:21:"gallery/theme.min.css";i:196;s:20:"group/editor-rtl.css";i:197;s:24:"group/editor-rtl.min.css";i:198;s:16:"group/editor.css";i:199;s:20:"group/editor.min.css";i:200;s:19:"group/style-rtl.css";i:201;s:23:"group/style-rtl.min.css";i:202;s:15:"group/style.css";i:203;s:19:"group/style.min.css";i:204;s:19:"group/theme-rtl.css";i:205;s:23:"group/theme-rtl.min.css";i:206;s:15:"group/theme.css";i:207;s:19:"group/theme.min.css";i:208;s:21:"heading/style-rtl.css";i:209;s:25:"heading/style-rtl.min.css";i:210;s:17:"heading/style.css";i:211;s:21:"heading/style.min.css";i:212;s:19:"html/editor-rtl.css";i:213;s:23:"html/editor-rtl.min.css";i:214;s:15:"html/editor.css";i:215;s:19:"html/editor.min.css";i:216;s:19:"icon/editor-rtl.css";i:217;s:23:"icon/editor-rtl.min.css";i:218;s:15:"icon/editor.css";i:219;s:19:"icon/editor.min.css";i:220;s:18:"icon/style-rtl.css";i:221;s:22:"icon/style-rtl.min.css";i:222;s:14:"icon/style.css";i:223;s:18:"icon/style.min.css";i:224;s:20:"image/editor-rtl.css";i:225;s:24:"image/editor-rtl.min.css";i:226;s:16:"image/editor.css";i:227;s:20:"image/editor.min.css";i:228;s:19:"image/style-rtl.css";i:229;s:23:"image/style-rtl.min.css";i:230;s:15:"image/style.css";i:231;s:19:"image/style.min.css";i:232;s:19:"image/theme-rtl.css";i:233;s:23:"image/theme-rtl.min.css";i:234;s:15:"image/theme.css";i:235;s:19:"image/theme.min.css";i:236;s:29:"latest-comments/style-rtl.css";i:237;s:33:"latest-comments/style-rtl.min.css";i:238;s:25:"latest-comments/style.css";i:239;s:29:"latest-comments/style.min.css";i:240;s:27:"latest-posts/editor-rtl.css";i:241;s:31:"latest-posts/editor-rtl.min.css";i:242;s:23:"latest-posts/editor.css";i:243;s:27:"latest-posts/editor.min.css";i:244;s:26:"latest-posts/style-rtl.css";i:245;s:30:"latest-posts/style-rtl.min.css";i:246;s:22:"latest-posts/style.css";i:247;s:26:"latest-posts/style.min.css";i:248;s:18:"list/style-rtl.css";i:249;s:22:"list/style-rtl.min.css";i:250;s:14:"list/style.css";i:251;s:18:"list/style.min.css";i:252;s:22:"loginout/style-rtl.css";i:253;s:26:"loginout/style-rtl.min.css";i:254;s:18:"loginout/style.css";i:255;s:22:"loginout/style.min.css";i:256;s:19:"math/editor-rtl.css";i:257;s:23:"math/editor-rtl.min.css";i:258;s:15:"math/editor.css";i:259;s:19:"math/editor.min.css";i:260;s:18:"math/style-rtl.css";i:261;s:22:"math/style-rtl.min.css";i:262;s:14:"math/style.css";i:263;s:18:"math/style.min.css";i:264;s:25:"media-text/editor-rtl.css";i:265;s:29:"media-text/editor-rtl.min.css";i:266;s:21:"media-text/editor.css";i:267;s:25:"media-text/editor.min.css";i:268;s:24:"media-text/style-rtl.css";i:269;s:28:"media-text/style-rtl.min.css";i:270;s:20:"media-text/style.css";i:271;s:24:"media-text/style.min.css";i:272;s:19:"more/editor-rtl.css";i:273;s:23:"more/editor-rtl.min.css";i:274;s:15:"more/editor.css";i:275;s:19:"more/editor.min.css";i:276;s:30:"navigation-link/editor-rtl.css";i:277;s:34:"navigation-link/editor-rtl.min.css";i:278;s:26:"navigation-link/editor.css";i:279;s:30:"navigation-link/editor.min.css";i:280;s:29:"navigation-link/style-rtl.css";i:281;s:33:"navigation-link/style-rtl.min.css";i:282;s:25:"navigation-link/style.css";i:283;s:29:"navigation-link/style.min.css";i:284;s:38:"navigation-overlay-close/style-rtl.css";i:285;s:42:"navigation-overlay-close/style-rtl.min.css";i:286;s:34:"navigation-overlay-close/style.css";i:287;s:38:"navigation-overlay-close/style.min.css";i:288;s:33:"navigation-submenu/editor-rtl.css";i:289;s:37:"navigation-submenu/editor-rtl.min.css";i:290;s:29:"navigation-submenu/editor.css";i:291;s:33:"navigation-submenu/editor.min.css";i:292;s:25:"navigation/editor-rtl.css";i:293;s:29:"navigation/editor-rtl.min.css";i:294;s:21:"navigation/editor.css";i:295;s:25:"navigation/editor.min.css";i:296;s:24:"navigation/style-rtl.css";i:297;s:28:"navigation/style-rtl.min.css";i:298;s:20:"navigation/style.css";i:299;s:24:"navigation/style.min.css";i:300;s:23:"nextpage/editor-rtl.css";i:301;s:27:"nextpage/editor-rtl.min.css";i:302;s:19:"nextpage/editor.css";i:303;s:23:"nextpage/editor.min.css";i:304;s:24:"page-list/editor-rtl.css";i:305;s:28:"page-list/editor-rtl.min.css";i:306;s:20:"page-list/editor.css";i:307;s:24:"page-list/editor.min.css";i:308;s:23:"page-list/style-rtl.css";i:309;s:27:"page-list/style-rtl.min.css";i:310;s:19:"page-list/style.css";i:311;s:23:"page-list/style.min.css";i:312;s:24:"paragraph/editor-rtl.css";i:313;s:28:"paragraph/editor-rtl.min.css";i:314;s:20:"paragraph/editor.css";i:315;s:24:"paragraph/editor.min.css";i:316;s:23:"paragraph/style-rtl.css";i:317;s:27:"paragraph/style-rtl.min.css";i:318;s:19:"paragraph/style.css";i:319;s:23:"paragraph/style.min.css";i:320;s:28:"playlist-track/style-rtl.css";i:321;s:32:"playlist-track/style-rtl.min.css";i:322;s:24:"playlist-track/style.css";i:323;s:28:"playlist-track/style.min.css";i:324;s:23:"playlist/editor-rtl.css";i:325;s:27:"playlist/editor-rtl.min.css";i:326;s:19:"playlist/editor.css";i:327;s:23:"playlist/editor.min.css";i:328;s:22:"playlist/style-rtl.css";i:329;s:26:"playlist/style-rtl.min.css";i:330;s:18:"playlist/style.css";i:331;s:22:"playlist/style.min.css";i:332;s:35:"post-author-biography/style-rtl.css";i:333;s:39:"post-author-biography/style-rtl.min.css";i:334;s:31:"post-author-biography/style.css";i:335;s:35:"post-author-biography/style.min.css";i:336;s:30:"post-author-name/style-rtl.css";i:337;s:34:"post-author-name/style-rtl.min.css";i:338;s:26:"post-author-name/style.css";i:339;s:30:"post-author-name/style.min.css";i:340;s:26:"post-author/editor-rtl.css";i:341;s:30:"post-author/editor-rtl.min.css";i:342;s:22:"post-author/editor.css";i:343;s:26:"post-author/editor.min.css";i:344;s:25:"post-author/style-rtl.css";i:345;s:29:"post-author/style-rtl.min.css";i:346;s:21:"post-author/style.css";i:347;s:25:"post-author/style.min.css";i:348;s:33:"post-comments-count/style-rtl.css";i:349;s:37:"post-comments-count/style-rtl.min.css";i:350;s:29:"post-comments-count/style.css";i:351;s:33:"post-comments-count/style.min.css";i:352;s:33:"post-comments-form/editor-rtl.css";i:353;s:37:"post-comments-form/editor-rtl.min.css";i:354;s:29:"post-comments-form/editor.css";i:355;s:33:"post-comments-form/editor.min.css";i:356;s:32:"post-comments-form/style-rtl.css";i:357;s:36:"post-comments-form/style-rtl.min.css";i:358;s:28:"post-comments-form/style.css";i:359;s:32:"post-comments-form/style.min.css";i:360;s:32:"post-comments-link/style-rtl.css";i:361;s:36:"post-comments-link/style-rtl.min.css";i:362;s:28:"post-comments-link/style.css";i:363;s:32:"post-comments-link/style.min.css";i:364;s:26:"post-content/style-rtl.css";i:365;s:30:"post-content/style-rtl.min.css";i:366;s:22:"post-content/style.css";i:367;s:26:"post-content/style.min.css";i:368;s:23:"post-date/style-rtl.css";i:369;s:27:"post-date/style-rtl.min.css";i:370;s:19:"post-date/style.css";i:371;s:23:"post-date/style.min.css";i:372;s:27:"post-excerpt/editor-rtl.css";i:373;s:31:"post-excerpt/editor-rtl.min.css";i:374;s:23:"post-excerpt/editor.css";i:375;s:27:"post-excerpt/editor.min.css";i:376;s:26:"post-excerpt/style-rtl.css";i:377;s:30:"post-excerpt/style-rtl.min.css";i:378;s:22:"post-excerpt/style.css";i:379;s:26:"post-excerpt/style.min.css";i:380;s:34:"post-featured-image/editor-rtl.css";i:381;s:38:"post-featured-image/editor-rtl.min.css";i:382;s:30:"post-featured-image/editor.css";i:383;s:34:"post-featured-image/editor.min.css";i:384;s:33:"post-featured-image/style-rtl.css";i:385;s:37:"post-featured-image/style-rtl.min.css";i:386;s:29:"post-featured-image/style.css";i:387;s:33:"post-featured-image/style.min.css";i:388;s:34:"post-navigation-link/style-rtl.css";i:389;s:38:"post-navigation-link/style-rtl.min.css";i:390;s:30:"post-navigation-link/style.css";i:391;s:34:"post-navigation-link/style.min.css";i:392;s:27:"post-template/style-rtl.css";i:393;s:31:"post-template/style-rtl.min.css";i:394;s:23:"post-template/style.css";i:395;s:27:"post-template/style.min.css";i:396;s:24:"post-terms/style-rtl.css";i:397;s:28:"post-terms/style-rtl.min.css";i:398;s:20:"post-terms/style.css";i:399;s:24:"post-terms/style.min.css";i:400;s:31:"post-time-to-read/style-rtl.css";i:401;s:35:"post-time-to-read/style-rtl.min.css";i:402;s:27:"post-time-to-read/style.css";i:403;s:31:"post-time-to-read/style.min.css";i:404;s:24:"post-title/style-rtl.css";i:405;s:28:"post-title/style-rtl.min.css";i:406;s:20:"post-title/style.css";i:407;s:24:"post-title/style.min.css";i:408;s:26:"preformatted/style-rtl.css";i:409;s:30:"preformatted/style-rtl.min.css";i:410;s:22:"preformatted/style.css";i:411;s:26:"preformatted/style.min.css";i:412;s:24:"pullquote/editor-rtl.css";i:413;s:28:"pullquote/editor-rtl.min.css";i:414;s:20:"pullquote/editor.css";i:415;s:24:"pullquote/editor.min.css";i:416;s:23:"pullquote/style-rtl.css";i:417;s:27:"pullquote/style-rtl.min.css";i:418;s:19:"pullquote/style.css";i:419;s:23:"pullquote/style.min.css";i:420;s:23:"pullquote/theme-rtl.css";i:421;s:27:"pullquote/theme-rtl.min.css";i:422;s:19:"pullquote/theme.css";i:423;s:23:"pullquote/theme.min.css";i:424;s:39:"query-pagination-numbers/editor-rtl.css";i:425;s:43:"query-pagination-numbers/editor-rtl.min.css";i:426;s:35:"query-pagination-numbers/editor.css";i:427;s:39:"query-pagination-numbers/editor.min.css";i:428;s:31:"query-pagination/editor-rtl.css";i:429;s:35:"query-pagination/editor-rtl.min.css";i:430;s:27:"query-pagination/editor.css";i:431;s:31:"query-pagination/editor.min.css";i:432;s:30:"query-pagination/style-rtl.css";i:433;s:34:"query-pagination/style-rtl.min.css";i:434;s:26:"query-pagination/style.css";i:435;s:30:"query-pagination/style.min.css";i:436;s:25:"query-title/style-rtl.css";i:437;s:29:"query-title/style-rtl.min.css";i:438;s:21:"query-title/style.css";i:439;s:25:"query-title/style.min.css";i:440;s:25:"query-total/style-rtl.css";i:441;s:29:"query-total/style-rtl.min.css";i:442;s:21:"query-total/style.css";i:443;s:25:"query-total/style.min.css";i:444;s:20:"query/editor-rtl.css";i:445;s:24:"query/editor-rtl.min.css";i:446;s:16:"query/editor.css";i:447;s:20:"query/editor.min.css";i:448;s:19:"quote/style-rtl.css";i:449;s:23:"quote/style-rtl.min.css";i:450;s:15:"quote/style.css";i:451;s:19:"quote/style.min.css";i:452;s:19:"quote/theme-rtl.css";i:453;s:23:"quote/theme-rtl.min.css";i:454;s:15:"quote/theme.css";i:455;s:19:"quote/theme.min.css";i:456;s:23:"read-more/style-rtl.css";i:457;s:27:"read-more/style-rtl.min.css";i:458;s:19:"read-more/style.css";i:459;s:23:"read-more/style.min.css";i:460;s:18:"rss/editor-rtl.css";i:461;s:22:"rss/editor-rtl.min.css";i:462;s:14:"rss/editor.css";i:463;s:18:"rss/editor.min.css";i:464;s:17:"rss/style-rtl.css";i:465;s:21:"rss/style-rtl.min.css";i:466;s:13:"rss/style.css";i:467;s:17:"rss/style.min.css";i:468;s:21:"search/editor-rtl.css";i:469;s:25:"search/editor-rtl.min.css";i:470;s:17:"search/editor.css";i:471;s:21:"search/editor.min.css";i:472;s:20:"search/style-rtl.css";i:473;s:24:"search/style-rtl.min.css";i:474;s:16:"search/style.css";i:475;s:20:"search/style.min.css";i:476;s:20:"search/theme-rtl.css";i:477;s:24:"search/theme-rtl.min.css";i:478;s:16:"search/theme.css";i:479;s:20:"search/theme.min.css";i:480;s:24:"separator/editor-rtl.css";i:481;s:28:"separator/editor-rtl.min.css";i:482;s:20:"separator/editor.css";i:483;s:24:"separator/editor.min.css";i:484;s:23:"separator/style-rtl.css";i:485;s:27:"separator/style-rtl.min.css";i:486;s:19:"separator/style.css";i:487;s:23:"separator/style.min.css";i:488;s:23:"separator/theme-rtl.css";i:489;s:27:"separator/theme-rtl.min.css";i:490;s:19:"separator/theme.css";i:491;s:23:"separator/theme.min.css";i:492;s:24:"shortcode/editor-rtl.css";i:493;s:28:"shortcode/editor-rtl.min.css";i:494;s:20:"shortcode/editor.css";i:495;s:24:"shortcode/editor.min.css";i:496;s:24:"site-logo/editor-rtl.css";i:497;s:28:"site-logo/editor-rtl.min.css";i:498;s:20:"site-logo/editor.css";i:499;s:24:"site-logo/editor.min.css";i:500;s:23:"site-logo/style-rtl.css";i:501;s:27:"site-logo/style-rtl.min.css";i:502;s:19:"site-logo/style.css";i:503;s:23:"site-logo/style.min.css";i:504;s:27:"site-tagline/editor-rtl.css";i:505;s:31:"site-tagline/editor-rtl.min.css";i:506;s:23:"site-tagline/editor.css";i:507;s:27:"site-tagline/editor.min.css";i:508;s:26:"site-tagline/style-rtl.css";i:509;s:30:"site-tagline/style-rtl.min.css";i:510;s:22:"site-tagline/style.css";i:511;s:26:"site-tagline/style.min.css";i:512;s:25:"site-title/editor-rtl.css";i:513;s:29:"site-title/editor-rtl.min.css";i:514;s:21:"site-title/editor.css";i:515;s:25:"site-title/editor.min.css";i:516;s:24:"site-title/style-rtl.css";i:517;s:28:"site-title/style-rtl.min.css";i:518;s:20:"site-title/style.css";i:519;s:24:"site-title/style.min.css";i:520;s:26:"social-link/editor-rtl.css";i:521;s:30:"social-link/editor-rtl.min.css";i:522;s:22:"social-link/editor.css";i:523;s:26:"social-link/editor.min.css";i:524;s:27:"social-links/editor-rtl.css";i:525;s:31:"social-links/editor-rtl.min.css";i:526;s:23:"social-links/editor.css";i:527;s:27:"social-links/editor.min.css";i:528;s:26:"social-links/style-rtl.css";i:529;s:30:"social-links/style-rtl.min.css";i:530;s:22:"social-links/style.css";i:531;s:26:"social-links/style.min.css";i:532;s:21:"spacer/editor-rtl.css";i:533;s:25:"spacer/editor-rtl.min.css";i:534;s:17:"spacer/editor.css";i:535;s:21:"spacer/editor.min.css";i:536;s:20:"spacer/style-rtl.css";i:537;s:24:"spacer/style-rtl.min.css";i:538;s:16:"spacer/style.css";i:539;s:20:"spacer/style.min.css";i:540;s:23:"tab-list/editor-rtl.css";i:541;s:27:"tab-list/editor-rtl.min.css";i:542;s:19:"tab-list/editor.css";i:543;s:23:"tab-list/editor.min.css";i:544;s:22:"tab-list/style-rtl.css";i:545;s:26:"tab-list/style-rtl.min.css";i:546;s:18:"tab-list/style.css";i:547;s:22:"tab-list/style.min.css";i:548;s:23:"tab-panel/style-rtl.css";i:549;s:27:"tab-panel/style-rtl.min.css";i:550;s:19:"tab-panel/style.css";i:551;s:23:"tab-panel/style.min.css";i:552;s:20:"table/editor-rtl.css";i:553;s:24:"table/editor-rtl.min.css";i:554;s:16:"table/editor.css";i:555;s:20:"table/editor.min.css";i:556;s:19:"table/style-rtl.css";i:557;s:23:"table/style-rtl.min.css";i:558;s:15:"table/style.css";i:559;s:19:"table/style.min.css";i:560;s:19:"table/theme-rtl.css";i:561;s:23:"table/theme-rtl.min.css";i:562;s:15:"table/theme.css";i:563;s:19:"table/theme.min.css";i:564;s:18:"tabs/style-rtl.css";i:565;s:22:"tabs/style-rtl.min.css";i:566;s:14:"tabs/style.css";i:567;s:18:"tabs/style.min.css";i:568;s:23:"tag-cloud/style-rtl.css";i:569;s:27:"tag-cloud/style-rtl.min.css";i:570;s:19:"tag-cloud/style.css";i:571;s:23:"tag-cloud/style.min.css";i:572;s:28:"template-part/editor-rtl.css";i:573;s:32:"template-part/editor-rtl.min.css";i:574;s:24:"template-part/editor.css";i:575;s:28:"template-part/editor.min.css";i:576;s:27:"template-part/theme-rtl.css";i:577;s:31:"template-part/theme-rtl.min.css";i:578;s:23:"template-part/theme.css";i:579;s:27:"template-part/theme.min.css";i:580;s:24:"term-count/style-rtl.css";i:581;s:28:"term-count/style-rtl.min.css";i:582;s:20:"term-count/style.css";i:583;s:24:"term-count/style.min.css";i:584;s:30:"term-description/style-rtl.css";i:585;s:34:"term-description/style-rtl.min.css";i:586;s:26:"term-description/style.css";i:587;s:30:"term-description/style.min.css";i:588;s:23:"term-name/style-rtl.css";i:589;s:27:"term-name/style-rtl.min.css";i:590;s:19:"term-name/style.css";i:591;s:23:"term-name/style.min.css";i:592;s:28:"term-template/editor-rtl.css";i:593;s:32:"term-template/editor-rtl.min.css";i:594;s:24:"term-template/editor.css";i:595;s:28:"term-template/editor.min.css";i:596;s:27:"term-template/style-rtl.css";i:597;s:31:"term-template/style-rtl.min.css";i:598;s:23:"term-template/style.css";i:599;s:27:"term-template/style.min.css";i:600;s:27:"text-columns/editor-rtl.css";i:601;s:31:"text-columns/editor-rtl.min.css";i:602;s:23:"text-columns/editor.css";i:603;s:27:"text-columns/editor.min.css";i:604;s:26:"text-columns/style-rtl.css";i:605;s:30:"text-columns/style-rtl.min.css";i:606;s:22:"text-columns/style.css";i:607;s:26:"text-columns/style.min.css";i:608;s:19:"verse/style-rtl.css";i:609;s:23:"verse/style-rtl.min.css";i:610;s:15:"verse/style.css";i:611;s:19:"verse/style.min.css";i:612;s:20:"video/editor-rtl.css";i:613;s:24:"video/editor-rtl.min.css";i:614;s:16:"video/editor.css";i:615;s:20:"video/editor.min.css";i:616;s:19:"video/style-rtl.css";i:617;s:23:"video/style-rtl.min.css";i:618;s:15:"video/style.css";i:619;s:19:"video/style.min.css";i:620;s:19:"video/theme-rtl.css";i:621;s:23:"video/theme-rtl.min.css";i:622;s:15:"video/theme.css";i:623;s:19:"video/theme.min.css";}}','on');
INSERT INTO `wp_options` VALUES (125,'studio_admin_username','admin','auto');
INSERT INTO `wp_options` VALUES (129,'nonce_key','xWp,+ZAU}nl,QlF3?4KpZl[Dv:5(S:EZg[xRlP^8mm~{LZ&=4 >BI[FI|_AoSojt','off');
INSERT INTO `wp_options` VALUES (130,'nonce_salt','(SiF2KSu@j)bIPA|^aRI%<O3VST/]r011lQ&`jiC,Tted;}r!@?-iifGf>tns@XF','off');
INSERT INTO `wp_options` VALUES (131,'theme_mods_twentytwentyfive','a:2:{s:18:"custom_css_post_id";i:-1;s:16:"sidebars_widgets";a:2:{s:4:"time";i:1790083846;s:4:"data";a:3:{s:19:"wp_inactive_widgets";a:0:{}s:9:"sidebar-1";a:3:{i:0;s:7:"block-2";i:1;s:7:"block-3";i:2;s:7:"block-4";}s:9:"sidebar-2";a:2:{i:0;s:7:"block-5";i:1;s:7:"block-6";}}}}','off');
INSERT INTO `wp_options` VALUES (132,'_transient_wp_styles_for_blocks','a:2:{s:4:"hash";s:32:"94289267f68ccac1fefa45915ab93347";s:6:"blocks";a:9:{s:32:"832dc2d864d79097d8b8b493ad93453b";s:0:"";s:32:"45d3e0c4afcbd8cf25cb1ba51abfb3d7";s:46:":root :where(.wp-block-icon svg){width: 24px;}";s:32:"feca6e996f694be2d29599793228e0d7";s:0:"";s:32:"5eef131663eddaf830554df656fc2968";s:324:":where(.wp-block-gallery.is-layout-flex){gap: var( --wp--style--gallery-gap-default, var( --gallery-block--gutter-size, var( --wp--style--block-gap, 0.5em ) ) );}:where(.wp-block-gallery.is-layout-grid){gap: var( --wp--style--gallery-gap-default, var( --gallery-block--gutter-size, var( --wp--style--block-gap, 0.5em ) ) );}";s:32:"c99c05932c6685777ec5b856698fcc7d";s:118:":where(.wp-block-latest-posts.is-layout-flex){gap: 1.25em;}:where(.wp-block-latest-posts.is-layout-grid){gap: 1.25em;}";s:32:"dec8d648f30b13caec8e61374591787d";s:120:":where(.wp-block-post-template.is-layout-flex){gap: 1.25em;}:where(.wp-block-post-template.is-layout-grid){gap: 1.25em;}";s:32:"6c35533f7a92cce94808323603db9fc8";s:120:":where(.wp-block-term-template.is-layout-flex){gap: 1.25em;}:where(.wp-block-term-template.is-layout-grid){gap: 1.25em;}";s:32:"6a0505cd5c78a87ed77570cda43c1132";s:102:":where(.wp-block-columns.is-layout-flex){gap: 2em;}:where(.wp-block-columns.is-layout-grid){gap: 2em;}";s:32:"25a66f156386551185570f72a9f7d44e";s:69:":root :where(.wp-block-pullquote){font-size: 1.5em;line-height: 1.6;}";}}','on');
INSERT INTO `wp_options` VALUES (135,'recovery_keys','a:0:{}','off');
INSERT INTO `wp_options` VALUES (136,'_site_transient_update_core','O:8:"stdClass":4:{s:7:"updates";a:2:{i:0;O:8:"stdClass":10:{s:8:"response";s:7:"upgrade";s:8:"download";s:59:"https://downloads.wordpress.org/release/wordpress-7.1.2.zip";s:6:"locale";s:5:"en_US";s:8:"packages";O:8:"stdClass":5:{s:4:"full";s:59:"https://downloads.wordpress.org/release/wordpress-7.1.2.zip";s:10:"no_content";s:70:"https://downloads.wordpress.org/release/wordpress-7.1.2-no-content.zip";s:11:"new_bundled";s:71:"https://downloads.wordpress.org/release/wordpress-7.1.2-new-bundled.zip";s:7:"partial";s:69:"https://downloads.wordpress.org/release/wordpress-7.1.2-partial-0.zip";s:8:"rollback";s:0:"";}s:7:"current";s:5:"7.1.2";s:7:"version";s:5:"7.1.2";s:11:"php_version";s:3:"7.4";s:13:"mysql_version";s:5:"5.5.5";s:11:"new_bundled";s:3:"6.7";s:15:"partial_version";s:3:"7.1";}i:1;O:8:"stdClass":11:{s:8:"response";s:10:"autoupdate";s:8:"download";s:51:"https://downloads.w.org/release/wordpress-7.1.2.zip";s:6:"locale";s:5:"en_US";s:8:"packages";O:8:"stdClass":5:{s:4:"full";s:51:"https://downloads.w.org/release/wordpress-7.1.2.zip";s:10:"no_content";s:62:"https://downloads.w.org/release/wordpress-7.1.2-no-content.zip";s:11:"new_bundled";s:63:"https://downloads.w.org/release/wordpress-7.1.2-new-bundled.zip";s:7:"partial";s:61:"https://downloads.w.org/release/wordpress-7.1.2-partial-0.zip";s:8:"rollback";s:62:"https://downloads.w.org/release/wordpress-7.1.2-rollback-0.zip";}s:7:"current";s:5:"7.1.2";s:7:"version";s:5:"7.1.2";s:11:"php_version";s:3:"7.4";s:13:"mysql_version";s:5:"5.5.5";s:11:"new_bundled";s:3:"6.7";s:15:"partial_version";s:3:"7.1";s:9:"new_files";s:0:"";}}s:12:"last_checked";i:1791126548;s:15:"version_checked";s:3:"7.1";s:12:"translations";a:0:{}}','off');
INSERT INTO `wp_options` VALUES (144,'_transient_health-check-site-status-result','{"good":17,"recommended":4,"critical":2}','on');
INSERT INTO `wp_options` VALUES (153,'ry_registration_db_version','1.0.0','auto');
INSERT INTO `wp_options` VALUES (160,'_site_transient_update_themes','O:8:"stdClass":5:{s:12:"last_checked";i:1791126550;s:7:"checked";a:4:{s:13:"rashtrotthana";s:5:"1.0.0";s:16:"twentytwentyfive";s:3:"1.5";s:16:"twentytwentyfour";s:3:"1.6";s:17:"twentytwentythree";s:3:"1.7";}s:8:"response";a:0:{}s:9:"no_update";a:3:{s:16:"twentytwentyfive";a:6:{s:5:"theme";s:16:"twentytwentyfive";s:11:"new_version";s:3:"1.5";s:3:"url";s:46:"https://wordpress.org/themes/twentytwentyfive/";s:7:"package";s:62:"https://downloads.wordpress.org/theme/twentytwentyfive.1.5.zip";s:8:"requires";s:3:"6.7";s:12:"requires_php";s:3:"7.2";}s:16:"twentytwentyfour";a:6:{s:5:"theme";s:16:"twentytwentyfour";s:11:"new_version";s:3:"1.6";s:3:"url";s:46:"https://wordpress.org/themes/twentytwentyfour/";s:7:"package";s:62:"https://downloads.wordpress.org/theme/twentytwentyfour.1.6.zip";s:8:"requires";s:3:"6.4";s:12:"requires_php";s:3:"7.0";}s:17:"twentytwentythree";a:6:{s:5:"theme";s:17:"twentytwentythree";s:11:"new_version";s:3:"1.7";s:3:"url";s:47:"https://wordpress.org/themes/twentytwentythree/";s:7:"package";s:63:"https://downloads.wordpress.org/theme/twentytwentythree.1.7.zip";s:8:"requires";s:3:"6.1";s:12:"requires_php";s:3:"5.6";}}s:12:"translations";a:0:{}}','off');
INSERT INTO `wp_options` VALUES (161,'wp_calendar_block_has_published_posts',1,'auto');
INSERT INTO `wp_options` VALUES (162,'category_children','a:0:{}','auto');
INSERT INTO `wp_options` VALUES (163,'current_theme','Rashtrotthana Yoga','auto');
INSERT INTO `wp_options` VALUES (164,'theme_switched','','auto');
INSERT INTO `wp_options` VALUES (167,'theme_mods_rashtrotthana','a:2:{s:18:"nav_menu_locations";a:0:{}s:18:"custom_css_post_id";i:-1;}','auto');
INSERT INTO `wp_options` VALUES (178,'auth_key','iqQ9WvY&^&p~/he4XNoSqbvR=&~q$&}r2g;cwLthtZ#qC04_}o#k.i~%{`PzRL}$','off');
INSERT INTO `wp_options` VALUES (179,'auth_salt','mbc[frly+)Ck; zfUjWS^@*:mNu:6T`,]TbbNn1jJrL)~K qR;AN[Msd+ S!mtQ<','off');
INSERT INTO `wp_options` VALUES (180,'logged_in_key','SJOIg}7?]%! ;jK9Dz<N6}L?#W`|m]xAW`w~JFjZd_F^ DFUFO X$d$TJz[cu_s=','off');
INSERT INTO `wp_options` VALUES (181,'logged_in_salt','_OS/,v(S}k>H!F}(~+1#ZQHr<xT@qCm@q6JxVfP5)V pa<#JV+=dBsvhJJe3XW&f','off');
INSERT INTO `wp_options` VALUES (185,'can_compress_scripts',1,'on');
INSERT INTO `wp_options` VALUES (200,'finished_updating_comment_type',1,'auto');
INSERT INTO `wp_options` VALUES (203,'acf_first_activated_version','6.8.10','on');
INSERT INTO `wp_options` VALUES (204,'acf_site_health','{"version":"6.8.10","plugin_type":"Free","update_source":"wordpress.org","wp_version":"7.1","mysql_version":"8.0.38-mysql-on-sqlite-3.0.2","is_multisite":false,"active_theme":{"name":"Rashtrotthana Yoga","version":"1.0.0","theme_uri":"","stylesheet":false},"active_plugins":{"advanced-custom-fields\\/acf.php":{"name":"Advanced Custom Fields","version":"6.8.10","plugin_uri":"https:\\/\\/www.advancedcustomfields.com"},"rashtrotthana-core\\/rashtrotthana-core.php":{"name":"Rashtrotthana Core","version":"1.0.0","plugin_uri":"https:\\/\\/rashtrotthana.org\\/"},"rashtrotthana-registration\\/rashtrotthana-registration.php":{"name":"Rashtrotthana Registration","version":"1.0.0","plugin_uri":"https:\\/\\/rashtrotthana.org\\/"}},"ui_field_groups":"0","php_field_groups":"0","json_field_groups":"0","rest_field_groups":"0","all_location_rules":["options_page==acf-options-about-us","post_type==activity","post_type==gallery_album","taxonomy==activity_category","post_type==center","post_type==event","options_page==acf-options-global-settings","options_page==acf-options-homepage"],"field_groups_by_post_type":[{"post_type":"activity","field_group_count":1},{"post_type":"center","field_group_count":1},{"post_type":"event","field_group_count":1},{"post_type":"gallery_album","field_group_count":1}],"number_of_fields_by_type":{"tab":4,"text":26,"wysiwyg":3,"image":4,"relationship":1,"select":2,"textarea":3,"email":2,"number":2,"true_false":2,"date_picker":1,"post_object":1,"url":4},"number_of_third_party_fields_by_type":{"repeater":8},"post_types_enabled":true,"ui_post_types":"0","json_post_types":"0","ui_taxonomies":"0","json_taxonomies":"0","rest_api_format":"light","admin_ui_enabled":true,"field_type-modal_enabled":true,"field_settings_tabs_enabled":false,"shortcode_enabled":false,"registered_acf_forms":"0","json_save_paths":1,"json_load_paths":1,"ai_enabled":false,"schema_support":false,"schema_ready_objects":{"blocks":0,"post_types":0},"event_first_activated":1790088917,"last_updated":1791126547}','off');
INSERT INTO `wp_options` VALUES (206,'options_ry_phone_primary','+91 80 1234 5678','off');
INSERT INTO `wp_options` VALUES (207,'_options_ry_phone_primary','field_ry_phone_primary','off');
INSERT INTO `wp_options` VALUES (208,'options_ry_email_primary','info@rashtrotthana.org','off');
INSERT INTO `wp_options` VALUES (209,'_options_ry_email_primary','field_ry_email_primary','off');
INSERT INTO `wp_options` VALUES (210,'options_ry_address_primary','#1, Rashtrotthana Complex,\nMalleswaram, Bengaluru - 560003\nKarnataka, India','off');
INSERT INTO `wp_options` VALUES (211,'_options_ry_address_primary','field_ry_address_primary','off');
INSERT INTO `wp_options` VALUES (212,'options_ry_facebook_url','#','off');
INSERT INTO `wp_options` VALUES (213,'_options_ry_facebook_url','field_ry_facebook_url','off');
INSERT INTO `wp_options` VALUES (214,'options_ry_instagram_url','#','off');
INSERT INTO `wp_options` VALUES (215,'_options_ry_instagram_url','field_ry_instagram_url','off');
INSERT INTO `wp_options` VALUES (216,'options_ry_youtube_url','#','off');
INSERT INTO `wp_options` VALUES (217,'_options_ry_youtube_url','field_ry_youtube_url','off');
INSERT INTO `wp_options` VALUES (218,'options_ry_twitter_url','#','off');
INSERT INTO `wp_options` VALUES (219,'_options_ry_twitter_url','field_ry_twitter_url','off');
INSERT INTO `wp_options` VALUES (220,'options_ry_hero_title','Building a Healthy & Sustainable Society','off');
INSERT INTO `wp_options` VALUES (221,'_options_ry_hero_title','field_ry_hero_title','off');
INSERT INTO `wp_options` VALUES (222,'options_ry_hero_subtitle','Through Yoga, Education, Culture and Service, we strive for the holistic well-being of every individual and the upliftment of the society.','off');
INSERT INTO `wp_options` VALUES (223,'_options_ry_hero_subtitle','field_ry_hero_subtitle','off');
INSERT INTO `wp_options` VALUES (224,'options_ry_hero_button_text','Explore Activities','off');
INSERT INTO `wp_options` VALUES (225,'_options_ry_hero_button_text','field_ry_hero_button_text','off');
INSERT INTO `wp_options` VALUES (226,'options_ry_hero_button_url','/activities/','off');
INSERT INTO `wp_options` VALUES (227,'_options_ry_hero_button_url','field_ry_hero_button_url','off');
INSERT INTO `wp_options` VALUES (228,'options_ry_home_featured_blocks','a:4:{i:0;a:3:{s:5:"title";s:15:"Yoga & Wellness";s:11:"description";s:70:"Yoga for all age groups, beginners, advanced and therapeutic programs.";s:5:"image";s:87:"http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/dsc08484.jpg";}i:1;a:3:{s:5:"title";s:9:"Education";s:11:"description";s:65:"Quality education and value-based learning for a better tomorrow.";s:5:"image";s:131:"http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1-.jpg";}i:2;a:3:{s:5:"title";s:14:"Arts & Culture";s:11:"description";s:59:"Nurturing talent through music, dance and traditional arts.";s:5:"image";s:90:"http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/dsc08548-2-.png";}i:3;a:3:{s:5:"title";s:17:"Community Service";s:11:"description";s:60:"Serving society through social and humanitarian initiatives.";s:5:"image";s:94:"http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/20200529-182250.jpg";}}','off');
INSERT INTO `wp_options` VALUES (229,'_options_ry_home_featured_blocks','field_ry_home_featured_blocks','off');
INSERT INTO `wp_options` VALUES (230,'options_ry_about_vision_title','Our Vision','off');
INSERT INTO `wp_options` VALUES (231,'_options_ry_about_vision_title','field_ry_about_vision_title','off');
INSERT INTO `wp_options` VALUES (232,'options_ry_about_vision_text','<p>To create a sustainable healthy society by integrating the ancient wisdom of Patanjali Yoga with modern scientific understanding, making holistic wellness accessible to all sections of society.</p>','off');
INSERT INTO `wp_options` VALUES (233,'_options_ry_about_vision_text','field_ry_about_vision_text','off');
INSERT INTO `wp_options` VALUES (234,'options_ry_about_vision_image',0,'off');
INSERT INTO `wp_options` VALUES (235,'_options_ry_about_vision_image','field_ry_about_vision_image','off');
INSERT INTO `wp_options` VALUES (236,'options_ry_about_mission_title','Our Mission','off');
INSERT INTO `wp_options` VALUES (237,'_options_ry_about_mission_title','field_ry_about_mission_title','off');
INSERT INTO `wp_options` VALUES (238,'options_ry_about_mission_text','<p>To establish world-class yoga training centers, conduct clinical research on yogic therapies, and cultivate a community of dedicated practitioners who lead by example in physical vitality, mental clarity, and spiritual harmony.</p>','off');
INSERT INTO `wp_options` VALUES (239,'_options_ry_about_mission_text','field_ry_about_mission_text','off');
INSERT INTO `wp_options` VALUES (240,'options_ry_about_mission_image',0,'off');
INSERT INTO `wp_options` VALUES (241,'_options_ry_about_mission_image','field_ry_about_mission_image','off');
INSERT INTO `wp_options` VALUES (259,'options_ry_home_founder_name','Dr. D. Veerendra Heggade','off');
INSERT INTO `wp_options` VALUES (260,'_options_ry_home_founder_name','field_hx_f_name','off');
INSERT INTO `wp_options` VALUES (261,'options_ry_home_founder_subtitle','The guiding philosophy behind the Rashtrotthana Yoga movement.','off');
INSERT INTO `wp_options` VALUES (262,'_options_ry_home_founder_subtitle','field_hx_f_sub','off');
INSERT INTO `wp_options` VALUES (263,'options_ry_home_founder_photo',0,'off');
INSERT INTO `wp_options` VALUES (264,'_options_ry_home_founder_photo','field_hx_f_img','off');
INSERT INTO `wp_options` VALUES (265,'options_ry_home_founder_bio','<strong>Dr. D. Veerendra Heggade</strong>, the revered Dharmadhikari of Dharmasthala and the founding inspiration behind Rashtrotthana Parishat, has been the beacon guiding this widespread Yoga movement.\n\nHis steadfast conviction that Yoga possesses the intrinsic power to transform individuals, heal bodily ailments, and foster socially conscious citizens has catalyzed the growth of our extensive network of community centers.\n\nUnder his inspiring guidance, Rashtrotthana Yoga remains steadfastly dedicated to service, integrity, and building a vigorous, harmonious nation.','off');
INSERT INTO `wp_options` VALUES (266,'_options_ry_home_founder_bio','field_hx_f_bio','off');
INSERT INTO `wp_options` VALUES (267,'options_ry_home_founder_quote','Yoga is not just an exercise; it is a way of life. It connects body, mind, and spirit to create a balanced, meaningful, and joyful existence.','off');
INSERT INTO `wp_options` VALUES (268,'_options_ry_home_founder_quote','field_hx_f_quote','off');
INSERT INTO `wp_options` VALUES (269,'options_ry_home_founder_quote_attr','Dr. D. Veerendra Heggade','off');
INSERT INTO `wp_options` VALUES (270,'_options_ry_home_founder_quote_attr','field_hx_f_qattr','off');
INSERT INTO `wp_options` VALUES (271,'options_ry_home_stats',5,'off');
INSERT INTO `wp_options` VALUES (272,'_options_ry_home_stats','field_hx_stats','off');
INSERT INTO `wp_options` VALUES (273,'options_ry_about_timeline','a:5:{i:0;a:3:{s:4:"year";s:11:"Early 1990s";s:5:"title";s:13:"The Beginning";s:4:"desc";s:68:"The vision took root with a small, intimate Yoga class in Jayanagar.";}i:1;a:3:{s:4:"year";s:17:"1995 &ndash; 2000";s:5:"title";s:9:"Expansion";s:4:"desc";s:75:"Yoga programs expanded rapidly to diverse residential sectors of Bengaluru.";}i:2;a:3:{s:4:"year";s:17:"2000 &ndash; 2010";s:5:"title";s:6:"Growth";s:4:"desc";s:77:"Establishment of multiple dedicated centers with morning and evening batches.";}i:3;a:3:{s:4:"year";s:17:"2010 &ndash; 2020";s:5:"title";s:12:"Reaching Out";s:4:"desc";s:75:"Reaching communities across Karnataka with 23+ fully equipped yoga centers.";}i:4;a:3:{s:4:"year";s:17:"2020 &amp; Beyond";s:5:"title";s:10:"The Future";s:4:"desc";s:74:"Advancing specialized yoga therapy, digital classes, and youth leadership.";}}','off');
INSERT INTO `wp_options` VALUES (274,'_options_ry_about_timeline','field_ax_timeline','off');
INSERT INTO `wp_options` VALUES (275,'options_ry_about_team','a:7:{i:0;a:4:{s:4:"name";s:13:"Sri M P Kumar";s:4:"role";s:33:"President, Rashtrotthana Parishat";s:4:"desc";s:0:"";s:5:"photo";s:79:"https://yoga.rashtrotthana.org/wp-content/uploads/2026/08/Sri-M-P-Kumar-2-1.png";}i:1;a:4:{s:4:"name";s:18:"Sri N Dinesh Hegde";s:4:"role";s:41:"General Secretary, Rashtrotthana Parishat";s:4:"desc";s:0:"";s:5:"photo";s:80:"https://yoga.rashtrotthana.org/wp-content/uploads/2026/08/Sri-Dinesh-Hegde-1.png";}i:2;a:4:{s:4:"name";s:16:"Sri K S Narayana";s:4:"role";s:33:"Treasurer, Rashtrotthana Parishat";s:4:"desc";s:0:"";s:5:"photo";s:83:"https://yoga.rashtrotthana.org/wp-content/uploads/2026/07/imgi_12_Sri-Narayan-2.jpg";}i:3;a:4:{s:4:"name";s:16:"Sri N V Raghuram";s:4:"role";s:46:"Chairman and Spiritual Founder of Yoga Bharati";s:4:"desc";s:0:"";s:5:"photo";s:73:"https://yoga.rashtrotthana.org/wp-content/uploads/2026/07/placeholder.png";}i:4;a:4:{s:4:"name";s:13:"Dr. Arati V B";s:4:"role";s:35:"Founder and Chairman, Vibhu Academy";s:4:"desc";s:0:"";s:5:"photo";s:73:"https://yoga.rashtrotthana.org/wp-content/uploads/2026/07/placeholder.png";}i:5;a:4:{s:4:"name";s:21:"Dr. Vinayachandra B K";s:4:"role";s:37:"Chief Consultant, Chanakya University";s:4:"desc";s:0:"";s:5:"photo";s:73:"https://yoga.rashtrotthana.org/wp-content/uploads/2026/07/placeholder.png";}i:6;a:4:{s:4:"name";s:13:"Dr. Omkar S N";s:4:"role";s:62:"Chief Research Scientist at Indian Institute of Science (IISc)";s:4:"desc";s:0:"";s:5:"photo";s:73:"https://yoga.rashtrotthana.org/wp-content/uploads/2026/07/placeholder.png";}}','off');
INSERT INTO `wp_options` VALUES (276,'_options_ry_about_team','field_ax_team','off');
INSERT INTO `wp_options` VALUES (284,'activity_category_children','a:0:{}','auto');
INSERT INTO `wp_options` VALUES (290,'acf_version','6.8.10','auto');
INSERT INTO `wp_options` VALUES (343,'options_ry_home_stats_0_value',1972,'auto');
INSERT INTO `wp_options` VALUES (344,'_options_ry_home_stats_0_value','field_hx_stat_val','auto');
INSERT INTO `wp_options` VALUES (345,'options_ry_home_stats_0_suffix','','auto');
INSERT INTO `wp_options` VALUES (346,'_options_ry_home_stats_0_suffix','field_hx_stat_suf','auto');
INSERT INTO `wp_options` VALUES (347,'options_ry_home_stats_0_label','Since','auto');
INSERT INTO `wp_options` VALUES (348,'_options_ry_home_stats_0_label','field_hx_stat_lbl','auto');
INSERT INTO `wp_options` VALUES (349,'options_ry_home_stats_1_value',35,'auto');
INSERT INTO `wp_options` VALUES (350,'_options_ry_home_stats_1_value','field_hx_stat_val','auto');
INSERT INTO `wp_options` VALUES (351,'options_ry_home_stats_1_suffix','+','auto');
INSERT INTO `wp_options` VALUES (352,'_options_ry_home_stats_1_suffix','field_hx_stat_suf','auto');
INSERT INTO `wp_options` VALUES (353,'options_ry_home_stats_1_label','Activities','auto');
INSERT INTO `wp_options` VALUES (354,'_options_ry_home_stats_1_label','field_hx_stat_lbl','auto');
INSERT INTO `wp_options` VALUES (355,'options_ry_home_stats_2_value',18,'auto');
INSERT INTO `wp_options` VALUES (356,'_options_ry_home_stats_2_value','field_hx_stat_val','auto');
INSERT INTO `wp_options` VALUES (357,'options_ry_home_stats_2_suffix','','auto');
INSERT INTO `wp_options` VALUES (358,'_options_ry_home_stats_2_suffix','field_hx_stat_suf','auto');
INSERT INTO `wp_options` VALUES (359,'options_ry_home_stats_2_label','Projects','auto');
INSERT INTO `wp_options` VALUES (360,'_options_ry_home_stats_2_label','field_hx_stat_lbl','auto');
INSERT INTO `wp_options` VALUES (361,'options_ry_home_stats_3_value',12,'auto');
INSERT INTO `wp_options` VALUES (362,'_options_ry_home_stats_3_value','field_hx_stat_val','auto');
INSERT INTO `wp_options` VALUES (363,'options_ry_home_stats_3_suffix','','auto');
INSERT INTO `wp_options` VALUES (364,'_options_ry_home_stats_3_suffix','field_hx_stat_suf','auto');
INSERT INTO `wp_options` VALUES (365,'options_ry_home_stats_3_label','Centers','auto');
INSERT INTO `wp_options` VALUES (366,'_options_ry_home_stats_3_label','field_hx_stat_lbl','auto');
INSERT INTO `wp_options` VALUES (367,'options_ry_home_stats_4_value',1000,'auto');
INSERT INTO `wp_options` VALUES (368,'_options_ry_home_stats_4_value','field_hx_stat_val','auto');
INSERT INTO `wp_options` VALUES (369,'options_ry_home_stats_4_suffix','+','auto');
INSERT INTO `wp_options` VALUES (370,'_options_ry_home_stats_4_suffix','field_hx_stat_suf','auto');
INSERT INTO `wp_options` VALUES (371,'options_ry_home_stats_4_label','Lives Impacted','auto');
INSERT INTO `wp_options` VALUES (372,'_options_ry_home_stats_4_label','field_hx_stat_lbl','auto');
INSERT INTO `wp_options` VALUES (373,'options_ry_carto_api_key','cb1_45bc_1_29c326230447342370d7bdef','auto');
INSERT INTO `wp_options` VALUES (374,'_options_ry_carto_api_key','field_ry_carto_api_key','auto');
INSERT INTO `wp_options` VALUES (428,'_site_transient_timeout_php_check_de6e4843b64a4c6da26d54cdae803134',1791659367,'off');
INSERT INTO `wp_options` VALUES (429,'_site_transient_php_check_de6e4843b64a4c6da26d54cdae803134','a:5:{s:19:"recommended_version";s:3:"8.3";s:15:"minimum_version";s:3:"7.4";s:12:"is_supported";b:1;s:9:"is_secure";b:1;s:13:"is_acceptable";b:1;}','off');
INSERT INTO `wp_options` VALUES (430,'_site_transient_timeout_browser_8a56ddc17d5dc536f819edcc326d5df6',1791660982,'off');
INSERT INTO `wp_options` VALUES (431,'_site_transient_browser_8a56ddc17d5dc536f819edcc326d5df6','a:10:{s:4:"name";s:6:"Chrome";s:7:"version";s:9:"154.0.0.0";s:8:"platform";s:7:"Windows";s:10:"update_url";s:29:"https://www.google.com/chrome";s:7:"img_src";s:43:"http://s.w.org/images/browsers/chrome.png?1";s:11:"img_src_ssl";s:44:"https://s.w.org/images/browsers/chrome.png?1";s:15:"current_version";s:2:"18";s:7:"upgrade";b:0;s:8:"insecure";b:0;s:6:"mobile";b:0;}','off');
INSERT INTO `wp_options` VALUES (482,'_site_transient_timeout_wp_theme_files_patterns-3dc51f416801322611c713e05f7ad3d8',1791128345,'off');
INSERT INTO `wp_options` VALUES (483,'_site_transient_wp_theme_files_patterns-3dc51f416801322611c713e05f7ad3d8','a:2:{s:7:"version";s:5:"1.0.0";s:8:"patterns";a:0:{}}','off');
INSERT INTO `wp_options` VALUES (486,'_site_transient_timeout_theme_roots',1791128350,'off');
INSERT INTO `wp_options` VALUES (487,'_site_transient_theme_roots','a:5:{s:18:"rashtrotthana-yoga";s:7:"/themes";s:13:"rashtrotthana";s:7:"/themes";s:16:"twentytwentyfive";s:7:"/themes";s:16:"twentytwentyfour";s:7:"/themes";s:17:"twentytwentythree";s:7:"/themes";}','off');
INSERT INTO `wp_options` VALUES (488,'_site_transient_update_plugins','O:8:"stdClass":5:{s:12:"last_checked";i:1791126551;s:8:"response";a:1:{s:23:"elementor/elementor.php";O:8:"stdClass":13:{s:2:"id";s:23:"w.org/plugins/elementor";s:4:"slug";s:9:"elementor";s:6:"plugin";s:23:"elementor/elementor.php";s:11:"new_version";s:5:"4.3.3";s:3:"url";s:40:"https://wordpress.org/plugins/elementor/";s:7:"package";s:58:"https://downloads.wordpress.org/plugin/elementor.4.3.3.zip";s:5:"icons";a:2:{s:2:"2x";s:62:"https://ps.w.org/elementor/assets/icon-256x256.gif?rev=3444228";s:2:"1x";s:62:"https://ps.w.org/elementor/assets/icon-128x128.gif?rev=3444228";}s:7:"banners";a:2:{s:2:"2x";s:65:"https://ps.w.org/elementor/assets/banner-1544x500.png?rev=3443226";s:2:"1x";s:64:"https://ps.w.org/elementor/assets/banner-772x250.png?rev=3443226";}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"6.8";s:6:"tested";s:5:"7.1.2";s:12:"requires_php";s:3:"7.4";s:16:"requires_plugins";a:0:{}}}s:12:"translations";a:0:{}s:9:"no_update";a:3:{s:30:"advanced-custom-fields/acf.php";O:8:"stdClass":10:{s:2:"id";s:36:"w.org/plugins/advanced-custom-fields";s:4:"slug";s:22:"advanced-custom-fields";s:6:"plugin";s:30:"advanced-custom-fields/acf.php";s:11:"new_version";s:6:"6.8.10";s:3:"url";s:53:"https://wordpress.org/plugins/advanced-custom-fields/";s:7:"package";s:72:"https://downloads.wordpress.org/plugin/advanced-custom-fields.6.8.10.zip";s:5:"icons";a:2:{s:2:"1x";s:67:"https://ps.w.org/advanced-custom-fields/assets/icon.svg?rev=3207824";s:3:"svg";s:67:"https://ps.w.org/advanced-custom-fields/assets/icon.svg?rev=3207824";}s:7:"banners";a:2:{s:2:"2x";s:78:"https://ps.w.org/advanced-custom-fields/assets/banner-1544x500.jpg?rev=3374528";s:2:"1x";s:77:"https://ps.w.org/advanced-custom-fields/assets/banner-772x250.jpg?rev=3374528";}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"6.2";}s:19:"akismet/akismet.php";O:8:"stdClass":10:{s:2:"id";s:21:"w.org/plugins/akismet";s:4:"slug";s:7:"akismet";s:6:"plugin";s:19:"akismet/akismet.php";s:11:"new_version";s:5:"5.7.2";s:3:"url";s:38:"https://wordpress.org/plugins/akismet/";s:7:"package";s:56:"https://downloads.wordpress.org/plugin/akismet.5.7.2.zip";s:5:"icons";a:2:{s:2:"2x";s:60:"https://ps.w.org/akismet/assets/icon-256x256.png?rev=2818463";s:2:"1x";s:60:"https://ps.w.org/akismet/assets/icon-128x128.png?rev=2818463";}s:7:"banners";a:2:{s:2:"2x";s:63:"https://ps.w.org/akismet/assets/banner-1544x500.png?rev=2900731";s:2:"1x";s:62:"https://ps.w.org/akismet/assets/banner-772x250.png?rev=2900731";}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"5.8";}s:9:"hello.php";O:8:"stdClass":10:{s:2:"id";s:25:"w.org/plugins/hello-dolly";s:4:"slug";s:11:"hello-dolly";s:6:"plugin";s:9:"hello.php";s:11:"new_version";s:5:"1.7.2";s:3:"url";s:42:"https://wordpress.org/plugins/hello-dolly/";s:7:"package";s:60:"https://downloads.wordpress.org/plugin/hello-dolly.1.7.2.zip";s:5:"icons";a:2:{s:2:"2x";s:64:"https://ps.w.org/hello-dolly/assets/icon-256x256.jpg?rev=2052855";s:2:"1x";s:64:"https://ps.w.org/hello-dolly/assets/icon-128x128.jpg?rev=2052855";}s:7:"banners";a:2:{s:2:"2x";s:67:"https://ps.w.org/hello-dolly/assets/banner-1544x500.jpg?rev=2645582";s:2:"1x";s:66:"https://ps.w.org/hello-dolly/assets/banner-772x250.jpg?rev=2052855";}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"4.6";}}s:7:"checked";a:8:{s:30:"advanced-custom-fields/acf.php";s:6:"6.8.10";s:19:"akismet/akismet.php";s:5:"5.7.2";s:23:"elementor/elementor.php";s:5:"4.2.3";s:9:"hello.php";s:5:"1.7.2";s:43:"rashtrotthana-admin/rashtrotthana-admin.php";s:5:"1.6.8";s:47:"rashtrotthana-chatbot/rashtrotthana-chatbot.php";s:5:"1.0.0";s:41:"rashtrotthana-core/rashtrotthana-core.php";s:5:"1.0.0";s:57:"rashtrotthana-registration/rashtrotthana-registration.php";s:5:"1.0.0";}}','off');

--
-- Table structure for table `wp_postmeta`
--

DROP TABLE IF EXISTS `wp_postmeta`;
CREATE TABLE `wp_postmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext DEFAULT NULL,
  PRIMARY KEY (`meta_id`),
  KEY `post_id` (`post_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=InnoDB AUTO_INCREMENT=2784 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `wp_postmeta`
--

INSERT INTO `wp_postmeta` VALUES (1,2,'_wp_page_template','default');
INSERT INTO `wp_postmeta` VALUES (2,3,'_wp_page_template','default');
INSERT INTO `wp_postmeta` VALUES (259,75,'_wp_page_template','page-about-us.php');
INSERT INTO `wp_postmeta` VALUES (260,76,'_wp_page_template','page-activities.php');
INSERT INTO `wp_postmeta` VALUES (261,77,'_wp_page_template','page-centers.php');
INSERT INTO `wp_postmeta` VALUES (262,78,'_wp_page_template','page-events.php');
INSERT INTO `wp_postmeta` VALUES (263,79,'_wp_page_template','page-gallery.php');
INSERT INTO `wp_postmeta` VALUES (264,80,'_wp_page_template','page-contact-us.php');
INSERT INTO `wp_postmeta` VALUES (651,82,'photos','a:6:{i:0;a:3:{s:5:"title";s:29:"Grand Dawn Mass Demonstration";s:3:"url";s:87:"http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/dsc08572.jpg";s:7:"caption";s:96:"Thousands of participants moving in harmony under the morning sky during International Yoga Day.";}i:1;a:3:{s:5:"title";s:30:"Surya Namaskar Collective Flow";s:3:"url";s:90:"http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/dsc08548-2-.png";s:7:"caption";s:90:"Practitioners executing the 12 postures of Surya Namaskar with focused rhythmic breathing.";}i:2;a:3:{s:5:"title";s:33:"Senior Instructors Guiding Asanas";s:3:"url";s:94:"http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/20200529-175453.jpg";s:7:"caption";s:84:"Certified Rashtrotthana Gurus demonstrating posture alignment on the central podium.";}i:3;a:3:{s:5:"title";s:29:"Mass Pranayama & Deep Silence";s:3:"url";s:94:"http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/20200529-182250.jpg";s:7:"caption";s:76:"A serene moment of Nadi Shodhana and Om chanting concluding the celebration.";}i:4;a:3:{s:5:"title";s:27:"Youth & Students Contingent";s:3:"url";s:138:"http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/08-02-22-rathasaptami-celebration-yoga-centres-bengaluru-5-.jpg";s:7:"caption";s:85:"Enthusiastic school and college students representing their educational institutions.";}i:5;a:3:{s:5:"title";s:37:"Community Felicitations & Benediction";s:3:"url";s:121:"http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/05-01-25-kutumba-milana-rysri-jayanagar-3-.jpg";s:7:"caption";s:77:"Honoring veteran yoga sadhakas for decades of selfless teaching in Bengaluru.";}}');
INSERT INTO `wp_postmeta` VALUES (652,82,'_photos','field_g_photos');
INSERT INTO `wp_postmeta` VALUES (653,82,'videos','a:2:{i:0;a:5:{s:5:"title";s:38:"International Yoga Day 2026 Highlights";s:8:"subtitle";s:40:"Grand Dawn Gathering & Collective Asanas";s:8:"duration";s:5:"02:45";s:5:"thumb";s:131:"http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1-.jpg";s:9:"embed_url";s:41:"https://www.youtube.com/embed/v7AYKMP6rOE";}i:1;a:5:{s:5:"title";s:38:"Surya Namaskar 108 Cycle Demonstration";s:8:"subtitle";s:34:"Masterclass Demonstration on Stage";s:8:"duration";s:5:"03:15";s:5:"thumb";s:142:"http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1-.jpg";s:9:"embed_url";s:41:"https://www.youtube.com/embed/inpok4MKVLM";}}');
INSERT INTO `wp_postmeta` VALUES (654,82,'_videos','field_g_videos');
INSERT INTO `wp_postmeta` VALUES (655,82,'_ry_image_url','http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/dsc08484.jpg');
INSERT INTO `wp_postmeta` VALUES (656,83,'photos','a:5:{i:0;a:3:{s:5:"title";s:32:"Animal Asanas & Playful Postures";s:3:"url";s:107:"http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/21-06-22-idy-celebration-12-.jpg";s:7:"caption";s:71:"Children joyfully practicing Simhasana and Vrikshasana balancing poses.";}i:1;a:3:{s:5:"title";s:28:"Young Sadhakas in Meditation";s:3:"url";s:125:"http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/21-06-24-idy-celebration-by-rysri-jayanagar-1-.jpg";s:7:"caption";s:81:"Cultivating still minds through guided breath mindfulness and Trataka techniques.";}i:2;a:3:{s:5:"title";s:30:"Vedic Chanting & Story Circles";s:3:"url";s:124:"http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/07-04-24-summer-camp-in-rysri-yoga-centres-1-.jpg";s:7:"caption";s:79:"Interactive sessions exploring value-based wisdom stories and Sanskrit shlokas.";}i:3;a:3:{s:5:"title";s:29:"Partner Yoga & Trust Building";s:3:"url";s:87:"http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/dsc08484.jpg";s:7:"caption";s:72:"Team-based balancing exercises fostering mutual respect and camaraderie.";}i:4;a:3:{s:5:"title";s:35:"Graduation Certificate Presentation";s:3:"url";s:87:"http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/dsc08572.jpg";s:7:"caption";s:79:"Proud participants receiving course completion shields alongside their parents.";}}');
INSERT INTO `wp_postmeta` VALUES (657,83,'_photos','field_g_photos');
INSERT INTO `wp_postmeta` VALUES (658,83,'videos','a:1:{i:0;a:5:{s:5:"title";s:34:"Children’s Summer Yoga Camp Reel";s:8:"subtitle";s:30:"Fun, Learning & Body Awareness";s:8:"duration";s:5:"01:58";s:5:"thumb";s:90:"http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/dsc08548-2-.png";s:9:"embed_url";s:41:"https://www.youtube.com/embed/sTANio_2E0Q";}}');
INSERT INTO `wp_postmeta` VALUES (659,83,'_videos','field_g_videos');
INSERT INTO `wp_postmeta` VALUES (660,83,'_ry_image_url','http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1-.jpg');
INSERT INTO `wp_postmeta` VALUES (661,84,'photos','a:4:{i:0;a:3:{s:5:"title";s:32:"Spine & Lumbar Alignment Therapy";s:3:"url";s:94:"http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/20200529-182250.jpg";s:7:"caption";s:85:"Tailored traction and gentle restorative asanas for participants with back stiffness.";}i:1;a:3:{s:5:"title";s:39:"Clinical Pulse Diagnosis & Consultation";s:3:"url";s:138:"http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/08-02-22-rathasaptami-celebration-yoga-centres-bengaluru-5-.jpg";s:7:"caption";s:79:"Ayurvedic vaidyas conducting personalized health evaluations prior to practice.";}i:2;a:3:{s:5:"title";s:34:"Prop-Supported Restorative Healing";s:3:"url";s:121:"http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/05-01-25-kutumba-milana-rysri-jayanagar-3-.jpg";s:7:"caption";s:75:"Using bolsters, belts, and chairs to assist recovery without spinal strain.";}i:3;a:3:{s:5:"title";s:47:"Therapeutic Pranayama & Vagus Nerve Stimulation";s:3:"url";s:131:"http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1-.jpg";s:7:"caption";s:84:"Targeted breathing rhythms shown to reduce systolic blood pressure and calm anxiety.";}}');
INSERT INTO `wp_postmeta` VALUES (662,84,'_photos','field_g_photos');
INSERT INTO `wp_postmeta` VALUES (663,84,'videos','a:1:{i:0;a:5:{s:5:"title";s:37:"Yoga for Stress & Chronic Pain Relief";s:8:"subtitle";s:33:"Clinical Insights & Gentle Asanas";s:8:"duration";s:5:"03:12";s:5:"thumb";s:142:"http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1-.jpg";s:9:"embed_url";s:41:"https://www.youtube.com/embed/4pKly2JojMw";}}');
INSERT INTO `wp_postmeta` VALUES (664,84,'_videos','field_g_videos');
INSERT INTO `wp_postmeta` VALUES (665,84,'_ry_image_url','http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/20200529-175453.jpg');
INSERT INTO `wp_postmeta` VALUES (666,85,'photos','a:4:{i:0;a:3:{s:5:"title";s:34:"108 Surya Namaskar Challenge Arena";s:3:"url";s:107:"http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/21-06-22-idy-celebration-12-.jpg";s:7:"caption";s:84:"Hundreds of youth simultaneously completing the demanding continuous namaskar cycle.";}i:1;a:3:{s:5:"title";s:40:"Traditional Martial Arts & Kalaripayattu";s:3:"url";s:125:"http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/21-06-24-idy-celebration-by-rysri-jayanagar-1-.jpg";s:7:"caption";s:76:"Dynamic demonstrations highlighting ancient physical culture and discipline.";}i:2;a:3:{s:5:"title";s:36:"Youth Leadership & Character Address";s:3:"url";s:124:"http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/07-04-24-summer-camp-in-rysri-yoga-centres-1-.jpg";s:7:"caption";s:79:"Eminent speakers inspiring participants to integrate yoga with nation-building.";}i:3;a:3:{s:5:"title";s:32:"Celebratory Group Acrobatic Yoga";s:3:"url";s:87:"http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/dsc08484.jpg";s:7:"caption";s:73:"Synchronized pyramid postures exhibited by senior Rashtrotthana athletes.";}}');
INSERT INTO `wp_postmeta` VALUES (667,85,'_photos','field_g_photos');
INSERT INTO `wp_postmeta` VALUES (668,85,'videos','a:1:{i:0;a:5:{s:5:"title";s:39:"National Youth Day Challenge Highlights";s:8:"subtitle";s:33:"Power, Stamina & Youth Leadership";s:8:"duration";s:5:"02:30";s:5:"thumb";s:87:"http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/dsc08572.jpg";s:9:"embed_url";s:41:"https://www.youtube.com/embed/v7AYKMP6rOE";}}');
INSERT INTO `wp_postmeta` VALUES (669,85,'_videos','field_g_videos');
INSERT INTO `wp_postmeta` VALUES (670,85,'_ry_image_url','http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1-.jpg');
INSERT INTO `wp_postmeta` VALUES (671,86,'photos','a:4:{i:0;a:3:{s:5:"title";s:32:"Neighborhood Morning Yoga Circle";s:3:"url";s:94:"http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/20200529-175453.jpg";s:7:"caption";s:69:"Instructors conducting open-air morning classes in community squares.";}i:1;a:3:{s:5:"title";s:39:"Nutritional Counseling & Health Checkup";s:3:"url";s:94:"http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/20200529-182250.jpg";s:7:"caption";s:76:"Free blood pressure checks, BMI tracking, and Ayurvedic wellness counseling.";}i:2;a:3:{s:5:"title";s:37:"Distributing Yoga Mats & Daily Guides";s:3:"url";s:138:"http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/08-02-22-rathasaptami-celebration-yoga-centres-bengaluru-5-.jpg";s:7:"caption";s:71:"Providing free practice mats and vernacular illustrated exercise books.";}i:3;a:3:{s:5:"title";s:34:"Smiles of Community Women Sadhakas";s:3:"url";s:121:"http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/05-01-25-kutumba-milana-rysri-jayanagar-3-.jpg";s:7:"caption";s:72:"Empowering homemakers with daily 20-minute restorative breath practices.";}}');
INSERT INTO `wp_postmeta` VALUES (672,86,'_photos','field_g_photos');
INSERT INTO `wp_postmeta` VALUES (673,86,'videos','a:1:{i:0;a:5:{s:5:"title";s:34:"Community Wellness Seva Documented";s:8:"subtitle";s:41:"Health For All in Bengaluru Urban Centers";s:8:"duration";s:5:"02:20";s:5:"thumb";s:131:"http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1-.jpg";s:9:"embed_url";s:41:"https://www.youtube.com/embed/inpok4MKVLM";}}');
INSERT INTO `wp_postmeta` VALUES (674,86,'_videos','field_g_videos');
INSERT INTO `wp_postmeta` VALUES (675,86,'_ry_image_url','http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/dsc08548-2-.png');
INSERT INTO `wp_postmeta` VALUES (676,87,'photos','a:4:{i:0;a:3:{s:5:"title";s:32:"Lamp Lighting & Vedic Invocation";s:3:"url";s:130:"http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1-.jpg";s:7:"caption";s:75:"Auspicious lighting of traditional deepas ushering in the cultural evening.";}i:1;a:3:{s:5:"title";s:40:"Nada Yoga Classical Bamboo Flute Session";s:3:"url";s:107:"http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/21-06-22-idy-celebration-12-.jpg";s:7:"caption";s:80:"Harmonizing heart rate and brainwave coherence through acoustic Indian melodies.";}i:2;a:3:{s:5:"title";s:33:"Candlelight Trataka & Dhyana Hall";s:3:"url";s:125:"http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/21-06-24-idy-celebration-by-rysri-jayanagar-1-.jpg";s:7:"caption";s:63:"Over 300 seekers immersed in steady candle flame concentration.";}i:3;a:3:{s:5:"title";s:34:"Satsang with Revered Yoga Scholars";s:3:"url";s:124:"http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/07-04-24-summer-camp-in-rysri-yoga-centres-1-.jpg";s:7:"caption";s:83:"Question & answer dialogue on living yogic ethics in modern corporate environments.";}}');
INSERT INTO `wp_postmeta` VALUES (677,87,'_photos','field_g_photos');
INSERT INTO `wp_postmeta` VALUES (678,87,'videos','a:1:{i:0;a:5:{s:5:"title";s:31:"Nada Yoga & Dhyana Evening Reel";s:8:"subtitle";s:34:"Soothing Flute & Silent Meditation";s:8:"duration";s:5:"02:15";s:5:"thumb";s:87:"http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/dsc08484.jpg";s:9:"embed_url";s:41:"https://www.youtube.com/embed/4pKly2JojMw";}}');
INSERT INTO `wp_postmeta` VALUES (679,87,'_videos','field_g_videos');
INSERT INTO `wp_postmeta` VALUES (680,87,'_ry_image_url','http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1-.jpg');
INSERT INTO `wp_postmeta` VALUES (681,88,'_wp_page_template','front-page.php');
INSERT INTO `wp_postmeta` VALUES (910,101,'_wp_attached_file','2026/09/dsc08484-scaled.jpg');
INSERT INTO `wp_postmeta` VALUES (911,101,'_wp_attachment_metadata','a:7:{s:5:"width";i:2560;s:6:"height";i:1853;s:4:"file";s:27:"2026/09/dsc08484-scaled.jpg";s:8:"filesize";i:646256;s:5:"sizes";a:6:{s:6:"medium";a:5:{s:4:"file";s:20:"dsc08484-300x217.jpg";s:5:"width";i:300;s:6:"height";i:217;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:19284;}s:5:"large";a:5:{s:4:"file";s:21:"dsc08484-1024x741.jpg";s:5:"width";i:1024;s:6:"height";i:741;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:131885;}s:9:"thumbnail";a:5:{s:4:"file";s:20:"dsc08484-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:8593;}s:12:"medium_large";a:5:{s:4:"file";s:20:"dsc08484-768x556.jpg";s:5:"width";i:768;s:6:"height";i:556;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:83378;}s:9:"1536x1536";a:5:{s:4:"file";s:22:"dsc08484-1536x1112.jpg";s:5:"width";i:1536;s:6:"height";i:1112;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:257399;}s:9:"2048x2048";a:5:{s:4:"file";s:22:"dsc08484-2048x1482.jpg";s:5:"width";i:2048;s:6:"height";i:1482;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:426178;}}s:10:"image_meta";a:13:{s:8:"aperture";s:3:"5.6";s:6:"credit";s:0:"";s:6:"camera";s:6:"ZV-E10";s:7:"caption";s:0:"";s:17:"created_timestamp";s:10:"1702834687";s:9:"copyright";s:0:"";s:12:"focal_length";s:2:"37";s:3:"iso";s:4:"5000";s:13:"shutter_speed";s:7:"0.00625";s:5:"title";s:0:"";s:11:"orientation";s:1:"1";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}s:14:"original_image";s:12:"dsc08484.jpg";}');
INSERT INTO `wp_postmeta` VALUES (912,74,'_thumbnail_id',101);
INSERT INTO `wp_postmeta` VALUES (913,102,'_wp_attached_file','2026/09/dsc08484-1-scaled.jpg');
INSERT INTO `wp_postmeta` VALUES (914,102,'_wp_attachment_metadata','a:7:{s:5:"width";i:2560;s:6:"height";i:1853;s:4:"file";s:29:"2026/09/dsc08484-1-scaled.jpg";s:8:"filesize";i:646256;s:5:"sizes";a:6:{s:6:"medium";a:5:{s:4:"file";s:22:"dsc08484-1-300x217.jpg";s:5:"width";i:300;s:6:"height";i:217;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:19284;}s:5:"large";a:5:{s:4:"file";s:23:"dsc08484-1-1024x741.jpg";s:5:"width";i:1024;s:6:"height";i:741;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:131885;}s:9:"thumbnail";a:5:{s:4:"file";s:22:"dsc08484-1-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:8593;}s:12:"medium_large";a:5:{s:4:"file";s:22:"dsc08484-1-768x556.jpg";s:5:"width";i:768;s:6:"height";i:556;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:83378;}s:9:"1536x1536";a:5:{s:4:"file";s:24:"dsc08484-1-1536x1112.jpg";s:5:"width";i:1536;s:6:"height";i:1112;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:257399;}s:9:"2048x2048";a:5:{s:4:"file";s:24:"dsc08484-1-2048x1482.jpg";s:5:"width";i:2048;s:6:"height";i:1482;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:426178;}}s:10:"image_meta";a:13:{s:8:"aperture";s:3:"5.6";s:6:"credit";s:0:"";s:6:"camera";s:6:"ZV-E10";s:7:"caption";s:0:"";s:17:"created_timestamp";s:10:"1702834687";s:9:"copyright";s:0:"";s:12:"focal_length";s:2:"37";s:3:"iso";s:4:"5000";s:13:"shutter_speed";s:7:"0.00625";s:5:"title";s:0:"";s:11:"orientation";s:1:"1";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}s:14:"original_image";s:14:"dsc08484-1.jpg";}');
INSERT INTO `wp_postmeta` VALUES (915,73,'_thumbnail_id',102);
INSERT INTO `wp_postmeta` VALUES (916,103,'_wp_attached_file','2026/09/dsc08484-2-scaled.jpg');
INSERT INTO `wp_postmeta` VALUES (917,103,'_wp_attachment_metadata','a:7:{s:5:"width";i:2560;s:6:"height";i:1853;s:4:"file";s:29:"2026/09/dsc08484-2-scaled.jpg";s:8:"filesize";i:646256;s:5:"sizes";a:6:{s:6:"medium";a:5:{s:4:"file";s:22:"dsc08484-2-300x217.jpg";s:5:"width";i:300;s:6:"height";i:217;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:19284;}s:5:"large";a:5:{s:4:"file";s:23:"dsc08484-2-1024x741.jpg";s:5:"width";i:1024;s:6:"height";i:741;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:131885;}s:9:"thumbnail";a:5:{s:4:"file";s:22:"dsc08484-2-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:8593;}s:12:"medium_large";a:5:{s:4:"file";s:22:"dsc08484-2-768x556.jpg";s:5:"width";i:768;s:6:"height";i:556;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:83378;}s:9:"1536x1536";a:5:{s:4:"file";s:24:"dsc08484-2-1536x1112.jpg";s:5:"width";i:1536;s:6:"height";i:1112;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:257399;}s:9:"2048x2048";a:5:{s:4:"file";s:24:"dsc08484-2-2048x1482.jpg";s:5:"width";i:2048;s:6:"height";i:1482;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:426178;}}s:10:"image_meta";a:13:{s:8:"aperture";s:3:"5.6";s:6:"credit";s:0:"";s:6:"camera";s:6:"ZV-E10";s:7:"caption";s:0:"";s:17:"created_timestamp";s:10:"1702834687";s:9:"copyright";s:0:"";s:12:"focal_length";s:2:"37";s:3:"iso";s:4:"5000";s:13:"shutter_speed";s:7:"0.00625";s:5:"title";s:0:"";s:11:"orientation";s:1:"1";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}s:14:"original_image";s:14:"dsc08484-2.jpg";}');
INSERT INTO `wp_postmeta` VALUES (918,72,'_thumbnail_id',103);
INSERT INTO `wp_postmeta` VALUES (919,104,'_wp_attached_file','2026/09/dsc08484-3-scaled.jpg');
INSERT INTO `wp_postmeta` VALUES (920,104,'_wp_attachment_metadata','a:7:{s:5:"width";i:2560;s:6:"height";i:1853;s:4:"file";s:29:"2026/09/dsc08484-3-scaled.jpg";s:8:"filesize";i:646256;s:5:"sizes";a:6:{s:6:"medium";a:5:{s:4:"file";s:22:"dsc08484-3-300x217.jpg";s:5:"width";i:300;s:6:"height";i:217;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:19284;}s:5:"large";a:5:{s:4:"file";s:23:"dsc08484-3-1024x741.jpg";s:5:"width";i:1024;s:6:"height";i:741;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:131885;}s:9:"thumbnail";a:5:{s:4:"file";s:22:"dsc08484-3-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:8593;}s:12:"medium_large";a:5:{s:4:"file";s:22:"dsc08484-3-768x556.jpg";s:5:"width";i:768;s:6:"height";i:556;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:83378;}s:9:"1536x1536";a:5:{s:4:"file";s:24:"dsc08484-3-1536x1112.jpg";s:5:"width";i:1536;s:6:"height";i:1112;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:257399;}s:9:"2048x2048";a:5:{s:4:"file";s:24:"dsc08484-3-2048x1482.jpg";s:5:"width";i:2048;s:6:"height";i:1482;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:426178;}}s:10:"image_meta";a:13:{s:8:"aperture";s:3:"5.6";s:6:"credit";s:0:"";s:6:"camera";s:6:"ZV-E10";s:7:"caption";s:0:"";s:17:"created_timestamp";s:10:"1702834687";s:9:"copyright";s:0:"";s:12:"focal_length";s:2:"37";s:3:"iso";s:4:"5000";s:13:"shutter_speed";s:7:"0.00625";s:5:"title";s:0:"";s:11:"orientation";s:1:"1";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}s:14:"original_image";s:14:"dsc08484-3.jpg";}');
INSERT INTO `wp_postmeta` VALUES (921,71,'_thumbnail_id',104);
INSERT INTO `wp_postmeta` VALUES (922,105,'_wp_attached_file','2026/09/07-04-24-summer-camp-in-rysri-yoga-centres-1--scaled.jpg');
INSERT INTO `wp_postmeta` VALUES (923,105,'_wp_attachment_metadata','a:7:{s:5:"width";i:2560;s:6:"height";i:1414;s:4:"file";s:64:"2026/09/07-04-24-summer-camp-in-rysri-yoga-centres-1--scaled.jpg";s:8:"filesize";i:633666;s:5:"sizes";a:6:{s:6:"medium";a:5:{s:4:"file";s:57:"07-04-24-summer-camp-in-rysri-yoga-centres-1--300x166.jpg";s:5:"width";i:300;s:6:"height";i:166;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:20429;}s:5:"large";a:5:{s:4:"file";s:58:"07-04-24-summer-camp-in-rysri-yoga-centres-1--1024x566.jpg";s:5:"width";i:1024;s:6:"height";i:566;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:167679;}s:9:"thumbnail";a:5:{s:4:"file";s:57:"07-04-24-summer-camp-in-rysri-yoga-centres-1--150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:10118;}s:12:"medium_large";a:5:{s:4:"file";s:57:"07-04-24-summer-camp-in-rysri-yoga-centres-1--768x424.jpg";s:5:"width";i:768;s:6:"height";i:424;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:103922;}s:9:"1536x1536";a:5:{s:4:"file";s:58:"07-04-24-summer-camp-in-rysri-yoga-centres-1--1536x848.jpg";s:5:"width";i:1536;s:6:"height";i:848;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:308491;}s:9:"2048x2048";a:5:{s:4:"file";s:59:"07-04-24-summer-camp-in-rysri-yoga-centres-1--2048x1131.jpg";s:5:"width";i:2048;s:6:"height";i:1131;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:465764;}}s:10:"image_meta";a:13:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"1";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}s:14:"original_image";s:49:"07-04-24-summer-camp-in-rysri-yoga-centres-1-.jpg";}');
INSERT INTO `wp_postmeta` VALUES (924,70,'_thumbnail_id',105);
INSERT INTO `wp_postmeta` VALUES (925,106,'_wp_attached_file','2026/09/07-04-24-summer-camp-in-rysri-yoga-centres-1-1-1-scaled.jpg');
INSERT INTO `wp_postmeta` VALUES (926,106,'_wp_attachment_metadata','a:7:{s:5:"width";i:2560;s:6:"height";i:1414;s:4:"file";s:67:"2026/09/07-04-24-summer-camp-in-rysri-yoga-centres-1-1-1-scaled.jpg";s:8:"filesize";i:633666;s:5:"sizes";a:6:{s:6:"medium";a:5:{s:4:"file";s:60:"07-04-24-summer-camp-in-rysri-yoga-centres-1-1-1-300x166.jpg";s:5:"width";i:300;s:6:"height";i:166;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:20429;}s:5:"large";a:5:{s:4:"file";s:61:"07-04-24-summer-camp-in-rysri-yoga-centres-1-1-1-1024x566.jpg";s:5:"width";i:1024;s:6:"height";i:566;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:167679;}s:9:"thumbnail";a:5:{s:4:"file";s:60:"07-04-24-summer-camp-in-rysri-yoga-centres-1-1-1-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:10118;}s:12:"medium_large";a:5:{s:4:"file";s:60:"07-04-24-summer-camp-in-rysri-yoga-centres-1-1-1-768x424.jpg";s:5:"width";i:768;s:6:"height";i:424;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:103922;}s:9:"1536x1536";a:5:{s:4:"file";s:61:"07-04-24-summer-camp-in-rysri-yoga-centres-1-1-1-1536x848.jpg";s:5:"width";i:1536;s:6:"height";i:848;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:308491;}s:9:"2048x2048";a:5:{s:4:"file";s:62:"07-04-24-summer-camp-in-rysri-yoga-centres-1-1-1-2048x1131.jpg";s:5:"width";i:2048;s:6:"height";i:1131;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:465764;}}s:10:"image_meta";a:13:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"1";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}s:14:"original_image";s:52:"07-04-24-summer-camp-in-rysri-yoga-centres-1-1-1.jpg";}');
INSERT INTO `wp_postmeta` VALUES (927,69,'_thumbnail_id',106);
INSERT INTO `wp_postmeta` VALUES (928,107,'_wp_attached_file','2026/09/07-04-24-summer-camp-in-rysri-yoga-centres-1-1-2-scaled.jpg');
INSERT INTO `wp_postmeta` VALUES (929,107,'_wp_attachment_metadata','a:7:{s:5:"width";i:2560;s:6:"height";i:1414;s:4:"file";s:67:"2026/09/07-04-24-summer-camp-in-rysri-yoga-centres-1-1-2-scaled.jpg";s:8:"filesize";i:633666;s:5:"sizes";a:6:{s:6:"medium";a:5:{s:4:"file";s:60:"07-04-24-summer-camp-in-rysri-yoga-centres-1-1-2-300x166.jpg";s:5:"width";i:300;s:6:"height";i:166;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:20429;}s:5:"large";a:5:{s:4:"file";s:61:"07-04-24-summer-camp-in-rysri-yoga-centres-1-1-2-1024x566.jpg";s:5:"width";i:1024;s:6:"height";i:566;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:167679;}s:9:"thumbnail";a:5:{s:4:"file";s:60:"07-04-24-summer-camp-in-rysri-yoga-centres-1-1-2-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:10118;}s:12:"medium_large";a:5:{s:4:"file";s:60:"07-04-24-summer-camp-in-rysri-yoga-centres-1-1-2-768x424.jpg";s:5:"width";i:768;s:6:"height";i:424;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:103922;}s:9:"1536x1536";a:5:{s:4:"file";s:61:"07-04-24-summer-camp-in-rysri-yoga-centres-1-1-2-1536x848.jpg";s:5:"width";i:1536;s:6:"height";i:848;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:308491;}s:9:"2048x2048";a:5:{s:4:"file";s:62:"07-04-24-summer-camp-in-rysri-yoga-centres-1-1-2-2048x1131.jpg";s:5:"width";i:2048;s:6:"height";i:1131;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:465764;}}s:10:"image_meta";a:13:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"1";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}s:14:"original_image";s:52:"07-04-24-summer-camp-in-rysri-yoga-centres-1-1-2.jpg";}');
INSERT INTO `wp_postmeta` VALUES (930,68,'_thumbnail_id',107);
INSERT INTO `wp_postmeta` VALUES (931,108,'_wp_attached_file','2026/09/07-04-24-summer-camp-in-rysri-yoga-centres-1-1-3-scaled.jpg');
INSERT INTO `wp_postmeta` VALUES (932,108,'_wp_attachment_metadata','a:7:{s:5:"width";i:2560;s:6:"height";i:1414;s:4:"file";s:67:"2026/09/07-04-24-summer-camp-in-rysri-yoga-centres-1-1-3-scaled.jpg";s:8:"filesize";i:633666;s:5:"sizes";a:6:{s:6:"medium";a:5:{s:4:"file";s:60:"07-04-24-summer-camp-in-rysri-yoga-centres-1-1-3-300x166.jpg";s:5:"width";i:300;s:6:"height";i:166;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:20429;}s:5:"large";a:5:{s:4:"file";s:61:"07-04-24-summer-camp-in-rysri-yoga-centres-1-1-3-1024x566.jpg";s:5:"width";i:1024;s:6:"height";i:566;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:167679;}s:9:"thumbnail";a:5:{s:4:"file";s:60:"07-04-24-summer-camp-in-rysri-yoga-centres-1-1-3-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:10118;}s:12:"medium_large";a:5:{s:4:"file";s:60:"07-04-24-summer-camp-in-rysri-yoga-centres-1-1-3-768x424.jpg";s:5:"width";i:768;s:6:"height";i:424;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:103922;}s:9:"1536x1536";a:5:{s:4:"file";s:61:"07-04-24-summer-camp-in-rysri-yoga-centres-1-1-3-1536x848.jpg";s:5:"width";i:1536;s:6:"height";i:848;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:308491;}s:9:"2048x2048";a:5:{s:4:"file";s:62:"07-04-24-summer-camp-in-rysri-yoga-centres-1-1-3-2048x1131.jpg";s:5:"width";i:2048;s:6:"height";i:1131;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:465764;}}s:10:"image_meta";a:13:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"1";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}s:14:"original_image";s:52:"07-04-24-summer-camp-in-rysri-yoga-centres-1-1-3.jpg";}');
INSERT INTO `wp_postmeta` VALUES (933,67,'_thumbnail_id',108);
INSERT INTO `wp_postmeta` VALUES (934,109,'_wp_attached_file','2026/09/21-06-24-idy-celebration-by-rysri-jayanagar-1--scaled.jpg');
INSERT INTO `wp_postmeta` VALUES (935,109,'_wp_attachment_metadata','a:7:{s:5:"width";i:2560;s:6:"height";i:890;s:4:"file";s:65:"2026/09/21-06-24-idy-celebration-by-rysri-jayanagar-1--scaled.jpg";s:8:"filesize";i:661276;s:5:"sizes";a:6:{s:6:"medium";a:5:{s:4:"file";s:58:"21-06-24-idy-celebration-by-rysri-jayanagar-1--300x104.jpg";s:5:"width";i:300;s:6:"height";i:104;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:14831;}s:5:"large";a:5:{s:4:"file";s:59:"21-06-24-idy-celebration-by-rysri-jayanagar-1--1024x356.jpg";s:5:"width";i:1024;s:6:"height";i:356;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:140304;}s:9:"thumbnail";a:5:{s:4:"file";s:58:"21-06-24-idy-celebration-by-rysri-jayanagar-1--150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:11272;}s:12:"medium_large";a:5:{s:4:"file";s:58:"21-06-24-idy-celebration-by-rysri-jayanagar-1--768x267.jpg";s:5:"width";i:768;s:6:"height";i:267;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:83213;}s:9:"1536x1536";a:5:{s:4:"file";s:59:"21-06-24-idy-celebration-by-rysri-jayanagar-1--1536x534.jpg";s:5:"width";i:1536;s:6:"height";i:534;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:286034;}s:9:"2048x2048";a:5:{s:4:"file";s:59:"21-06-24-idy-celebration-by-rysri-jayanagar-1--2048x712.jpg";s:5:"width";i:2048;s:6:"height";i:712;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:462233;}}s:10:"image_meta";a:13:{s:8:"aperture";s:1:"4";s:6:"credit";s:0:"";s:6:"camera";s:11:"NIKON Z 6_2";s:7:"caption";s:0:"";s:17:"created_timestamp";s:10:"1718932009";s:9:"copyright";s:0:"";s:12:"focal_length";s:2:"24";s:3:"iso";s:4:"4000";s:13:"shutter_speed";s:5:"0.005";s:5:"title";s:0:"";s:11:"orientation";s:1:"1";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}s:14:"original_image";s:50:"21-06-24-idy-celebration-by-rysri-jayanagar-1-.jpg";}');
INSERT INTO `wp_postmeta` VALUES (936,66,'_thumbnail_id',109);
INSERT INTO `wp_postmeta` VALUES (937,110,'_wp_attached_file','2026/09/21-06-24-idy-celebration-by-rysri-jayanagar-1-1-1-scaled.jpg');
INSERT INTO `wp_postmeta` VALUES (938,110,'_wp_attachment_metadata','a:7:{s:5:"width";i:2560;s:6:"height";i:890;s:4:"file";s:68:"2026/09/21-06-24-idy-celebration-by-rysri-jayanagar-1-1-1-scaled.jpg";s:8:"filesize";i:661276;s:5:"sizes";a:6:{s:6:"medium";a:5:{s:4:"file";s:61:"21-06-24-idy-celebration-by-rysri-jayanagar-1-1-1-300x104.jpg";s:5:"width";i:300;s:6:"height";i:104;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:14831;}s:5:"large";a:5:{s:4:"file";s:62:"21-06-24-idy-celebration-by-rysri-jayanagar-1-1-1-1024x356.jpg";s:5:"width";i:1024;s:6:"height";i:356;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:140304;}s:9:"thumbnail";a:5:{s:4:"file";s:61:"21-06-24-idy-celebration-by-rysri-jayanagar-1-1-1-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:11272;}s:12:"medium_large";a:5:{s:4:"file";s:61:"21-06-24-idy-celebration-by-rysri-jayanagar-1-1-1-768x267.jpg";s:5:"width";i:768;s:6:"height";i:267;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:83213;}s:9:"1536x1536";a:5:{s:4:"file";s:62:"21-06-24-idy-celebration-by-rysri-jayanagar-1-1-1-1536x534.jpg";s:5:"width";i:1536;s:6:"height";i:534;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:286034;}s:9:"2048x2048";a:5:{s:4:"file";s:62:"21-06-24-idy-celebration-by-rysri-jayanagar-1-1-1-2048x712.jpg";s:5:"width";i:2048;s:6:"height";i:712;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:462233;}}s:10:"image_meta";a:13:{s:8:"aperture";s:1:"4";s:6:"credit";s:0:"";s:6:"camera";s:11:"NIKON Z 6_2";s:7:"caption";s:0:"";s:17:"created_timestamp";s:10:"1718932009";s:9:"copyright";s:0:"";s:12:"focal_length";s:2:"24";s:3:"iso";s:4:"4000";s:13:"shutter_speed";s:5:"0.005";s:5:"title";s:0:"";s:11:"orientation";s:1:"1";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}s:14:"original_image";s:53:"21-06-24-idy-celebration-by-rysri-jayanagar-1-1-1.jpg";}');
INSERT INTO `wp_postmeta` VALUES (939,65,'_thumbnail_id',110);
INSERT INTO `wp_postmeta` VALUES (940,111,'_wp_attached_file','2026/09/21-06-24-idy-celebration-by-rysri-jayanagar-1-1-2-scaled.jpg');
INSERT INTO `wp_postmeta` VALUES (941,111,'_wp_attachment_metadata','a:7:{s:5:"width";i:2560;s:6:"height";i:890;s:4:"file";s:68:"2026/09/21-06-24-idy-celebration-by-rysri-jayanagar-1-1-2-scaled.jpg";s:8:"filesize";i:661276;s:5:"sizes";a:6:{s:6:"medium";a:5:{s:4:"file";s:61:"21-06-24-idy-celebration-by-rysri-jayanagar-1-1-2-300x104.jpg";s:5:"width";i:300;s:6:"height";i:104;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:14831;}s:5:"large";a:5:{s:4:"file";s:62:"21-06-24-idy-celebration-by-rysri-jayanagar-1-1-2-1024x356.jpg";s:5:"width";i:1024;s:6:"height";i:356;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:140304;}s:9:"thumbnail";a:5:{s:4:"file";s:61:"21-06-24-idy-celebration-by-rysri-jayanagar-1-1-2-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:11272;}s:12:"medium_large";a:5:{s:4:"file";s:61:"21-06-24-idy-celebration-by-rysri-jayanagar-1-1-2-768x267.jpg";s:5:"width";i:768;s:6:"height";i:267;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:83213;}s:9:"1536x1536";a:5:{s:4:"file";s:62:"21-06-24-idy-celebration-by-rysri-jayanagar-1-1-2-1536x534.jpg";s:5:"width";i:1536;s:6:"height";i:534;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:286034;}s:9:"2048x2048";a:5:{s:4:"file";s:62:"21-06-24-idy-celebration-by-rysri-jayanagar-1-1-2-2048x712.jpg";s:5:"width";i:2048;s:6:"height";i:712;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:462233;}}s:10:"image_meta";a:13:{s:8:"aperture";s:1:"4";s:6:"credit";s:0:"";s:6:"camera";s:11:"NIKON Z 6_2";s:7:"caption";s:0:"";s:17:"created_timestamp";s:10:"1718932009";s:9:"copyright";s:0:"";s:12:"focal_length";s:2:"24";s:3:"iso";s:4:"4000";s:13:"shutter_speed";s:5:"0.005";s:5:"title";s:0:"";s:11:"orientation";s:1:"1";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}s:14:"original_image";s:53:"21-06-24-idy-celebration-by-rysri-jayanagar-1-1-2.jpg";}');
INSERT INTO `wp_postmeta` VALUES (942,64,'_thumbnail_id',111);
INSERT INTO `wp_postmeta` VALUES (943,112,'_wp_attached_file','2026/09/21-06-24-idy-celebration-by-rysri-jayanagar-1-1-3-scaled.jpg');
INSERT INTO `wp_postmeta` VALUES (944,112,'_wp_attachment_metadata','a:7:{s:5:"width";i:2560;s:6:"height";i:890;s:4:"file";s:68:"2026/09/21-06-24-idy-celebration-by-rysri-jayanagar-1-1-3-scaled.jpg";s:8:"filesize";i:661276;s:5:"sizes";a:6:{s:6:"medium";a:5:{s:4:"file";s:61:"21-06-24-idy-celebration-by-rysri-jayanagar-1-1-3-300x104.jpg";s:5:"width";i:300;s:6:"height";i:104;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:14831;}s:5:"large";a:5:{s:4:"file";s:62:"21-06-24-idy-celebration-by-rysri-jayanagar-1-1-3-1024x356.jpg";s:5:"width";i:1024;s:6:"height";i:356;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:140304;}s:9:"thumbnail";a:5:{s:4:"file";s:61:"21-06-24-idy-celebration-by-rysri-jayanagar-1-1-3-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:11272;}s:12:"medium_large";a:5:{s:4:"file";s:61:"21-06-24-idy-celebration-by-rysri-jayanagar-1-1-3-768x267.jpg";s:5:"width";i:768;s:6:"height";i:267;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:83213;}s:9:"1536x1536";a:5:{s:4:"file";s:62:"21-06-24-idy-celebration-by-rysri-jayanagar-1-1-3-1536x534.jpg";s:5:"width";i:1536;s:6:"height";i:534;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:286034;}s:9:"2048x2048";a:5:{s:4:"file";s:62:"21-06-24-idy-celebration-by-rysri-jayanagar-1-1-3-2048x712.jpg";s:5:"width";i:2048;s:6:"height";i:712;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:462233;}}s:10:"image_meta";a:13:{s:8:"aperture";s:1:"4";s:6:"credit";s:0:"";s:6:"camera";s:11:"NIKON Z 6_2";s:7:"caption";s:0:"";s:17:"created_timestamp";s:10:"1718932009";s:9:"copyright";s:0:"";s:12:"focal_length";s:2:"24";s:3:"iso";s:4:"4000";s:13:"shutter_speed";s:5:"0.005";s:5:"title";s:0:"";s:11:"orientation";s:1:"1";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}s:14:"original_image";s:53:"21-06-24-idy-celebration-by-rysri-jayanagar-1-1-3.jpg";}');
INSERT INTO `wp_postmeta` VALUES (945,63,'_thumbnail_id',112);
INSERT INTO `wp_postmeta` VALUES (946,113,'_wp_attached_file','2026/09/21-06-22-idy-celebration-12--scaled.jpg');
INSERT INTO `wp_postmeta` VALUES (947,113,'_wp_attachment_metadata','a:7:{s:5:"width";i:2560;s:6:"height";i:1489;s:4:"file";s:47:"2026/09/21-06-22-idy-celebration-12--scaled.jpg";s:8:"filesize";i:659625;s:5:"sizes";a:6:{s:6:"medium";a:5:{s:4:"file";s:40:"21-06-22-idy-celebration-12--300x175.jpg";s:5:"width";i:300;s:6:"height";i:175;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:23725;}s:5:"large";a:5:{s:4:"file";s:41:"21-06-22-idy-celebration-12--1024x596.jpg";s:5:"width";i:1024;s:6:"height";i:596;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:186216;}s:9:"thumbnail";a:5:{s:4:"file";s:40:"21-06-22-idy-celebration-12--150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:11088;}s:12:"medium_large";a:5:{s:4:"file";s:40:"21-06-22-idy-celebration-12--768x447.jpg";s:5:"width";i:768;s:6:"height";i:447;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:119919;}s:9:"1536x1536";a:5:{s:4:"file";s:41:"21-06-22-idy-celebration-12--1536x893.jpg";s:5:"width";i:1536;s:6:"height";i:893;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:329061;}s:9:"2048x2048";a:5:{s:4:"file";s:42:"21-06-22-idy-celebration-12--2048x1191.jpg";s:5:"width";i:2048;s:6:"height";i:1191;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:487165;}}s:10:"image_meta";a:13:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"1";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}s:14:"original_image";s:32:"21-06-22-idy-celebration-12-.jpg";}');
INSERT INTO `wp_postmeta` VALUES (948,62,'_thumbnail_id',113);
INSERT INTO `wp_postmeta` VALUES (949,114,'_wp_attached_file','2026/09/21-06-22-idy-celebration-12-1-1-scaled.jpg');
INSERT INTO `wp_postmeta` VALUES (950,114,'_wp_attachment_metadata','a:7:{s:5:"width";i:2560;s:6:"height";i:1489;s:4:"file";s:50:"2026/09/21-06-22-idy-celebration-12-1-1-scaled.jpg";s:8:"filesize";i:659625;s:5:"sizes";a:6:{s:6:"medium";a:5:{s:4:"file";s:43:"21-06-22-idy-celebration-12-1-1-300x175.jpg";s:5:"width";i:300;s:6:"height";i:175;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:23725;}s:5:"large";a:5:{s:4:"file";s:44:"21-06-22-idy-celebration-12-1-1-1024x596.jpg";s:5:"width";i:1024;s:6:"height";i:596;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:186216;}s:9:"thumbnail";a:5:{s:4:"file";s:43:"21-06-22-idy-celebration-12-1-1-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:11088;}s:12:"medium_large";a:5:{s:4:"file";s:43:"21-06-22-idy-celebration-12-1-1-768x447.jpg";s:5:"width";i:768;s:6:"height";i:447;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:119919;}s:9:"1536x1536";a:5:{s:4:"file";s:44:"21-06-22-idy-celebration-12-1-1-1536x893.jpg";s:5:"width";i:1536;s:6:"height";i:893;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:329061;}s:9:"2048x2048";a:5:{s:4:"file";s:45:"21-06-22-idy-celebration-12-1-1-2048x1191.jpg";s:5:"width";i:2048;s:6:"height";i:1191;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:487165;}}s:10:"image_meta";a:13:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"1";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}s:14:"original_image";s:35:"21-06-22-idy-celebration-12-1-1.jpg";}');
INSERT INTO `wp_postmeta` VALUES (951,61,'_thumbnail_id',114);
INSERT INTO `wp_postmeta` VALUES (952,115,'_wp_attached_file','2026/09/21-06-22-idy-celebration-12-1-2-scaled.jpg');
INSERT INTO `wp_postmeta` VALUES (953,115,'_wp_attachment_metadata','a:7:{s:5:"width";i:2560;s:6:"height";i:1489;s:4:"file";s:50:"2026/09/21-06-22-idy-celebration-12-1-2-scaled.jpg";s:8:"filesize";i:659625;s:5:"sizes";a:6:{s:6:"medium";a:5:{s:4:"file";s:43:"21-06-22-idy-celebration-12-1-2-300x175.jpg";s:5:"width";i:300;s:6:"height";i:175;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:23725;}s:5:"large";a:5:{s:4:"file";s:44:"21-06-22-idy-celebration-12-1-2-1024x596.jpg";s:5:"width";i:1024;s:6:"height";i:596;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:186216;}s:9:"thumbnail";a:5:{s:4:"file";s:43:"21-06-22-idy-celebration-12-1-2-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:11088;}s:12:"medium_large";a:5:{s:4:"file";s:43:"21-06-22-idy-celebration-12-1-2-768x447.jpg";s:5:"width";i:768;s:6:"height";i:447;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:119919;}s:9:"1536x1536";a:5:{s:4:"file";s:44:"21-06-22-idy-celebration-12-1-2-1536x893.jpg";s:5:"width";i:1536;s:6:"height";i:893;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:329061;}s:9:"2048x2048";a:5:{s:4:"file";s:45:"21-06-22-idy-celebration-12-1-2-2048x1191.jpg";s:5:"width";i:2048;s:6:"height";i:1191;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:487165;}}s:10:"image_meta";a:13:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"1";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}s:14:"original_image";s:35:"21-06-22-idy-celebration-12-1-2.jpg";}');
INSERT INTO `wp_postmeta` VALUES (954,60,'_thumbnail_id',115);
INSERT INTO `wp_postmeta` VALUES (955,116,'_wp_attached_file','2026/09/21-06-22-idy-celebration-12-1-3-scaled.jpg');
INSERT INTO `wp_postmeta` VALUES (956,116,'_wp_attachment_metadata','a:7:{s:5:"width";i:2560;s:6:"height";i:1489;s:4:"file";s:50:"2026/09/21-06-22-idy-celebration-12-1-3-scaled.jpg";s:8:"filesize";i:659625;s:5:"sizes";a:6:{s:6:"medium";a:5:{s:4:"file";s:43:"21-06-22-idy-celebration-12-1-3-300x175.jpg";s:5:"width";i:300;s:6:"height";i:175;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:23725;}s:5:"large";a:5:{s:4:"file";s:44:"21-06-22-idy-celebration-12-1-3-1024x596.jpg";s:5:"width";i:1024;s:6:"height";i:596;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:186216;}s:9:"thumbnail";a:5:{s:4:"file";s:43:"21-06-22-idy-celebration-12-1-3-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:11088;}s:12:"medium_large";a:5:{s:4:"file";s:43:"21-06-22-idy-celebration-12-1-3-768x447.jpg";s:5:"width";i:768;s:6:"height";i:447;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:119919;}s:9:"1536x1536";a:5:{s:4:"file";s:44:"21-06-22-idy-celebration-12-1-3-1536x893.jpg";s:5:"width";i:1536;s:6:"height";i:893;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:329061;}s:9:"2048x2048";a:5:{s:4:"file";s:45:"21-06-22-idy-celebration-12-1-3-2048x1191.jpg";s:5:"width";i:2048;s:6:"height";i:1191;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:487165;}}s:10:"image_meta";a:13:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"1";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}s:14:"original_image";s:35:"21-06-22-idy-celebration-12-1-3.jpg";}');
INSERT INTO `wp_postmeta` VALUES (957,59,'_thumbnail_id',116);
INSERT INTO `wp_postmeta` VALUES (958,117,'_wp_attached_file','2026/09/05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1--scaled.jpg');
INSERT INTO `wp_postmeta` VALUES (959,117,'_wp_attachment_metadata','a:7:{s:5:"width";i:2560;s:6:"height";i:2213;s:4:"file";s:70:"2026/09/05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1--scaled.jpg";s:8:"filesize";i:1002251;s:5:"sizes";a:6:{s:6:"medium";a:5:{s:4:"file";s:63:"05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1--300x259.jpg";s:5:"width";i:300;s:6:"height";i:259;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:29465;}s:5:"large";a:5:{s:4:"file";s:64:"05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1--1024x885.jpg";s:5:"width";i:1024;s:6:"height";i:885;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:229549;}s:9:"thumbnail";a:5:{s:4:"file";s:63:"05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1--150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:10361;}s:12:"medium_large";a:5:{s:4:"file";s:63:"05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1--768x664.jpg";s:5:"width";i:768;s:6:"height";i:664;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:142414;}s:9:"1536x1536";a:5:{s:4:"file";s:65:"05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1--1536x1328.jpg";s:5:"width";i:1536;s:6:"height";i:1328;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:442997;}s:9:"2048x2048";a:5:{s:4:"file";s:65:"05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1--2048x1770.jpg";s:5:"width";i:2048;s:6:"height";i:1770;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:704592;}}s:10:"image_meta";a:13:{s:8:"aperture";s:3:"6.3";s:6:"credit";s:0:"";s:6:"camera";s:11:"NIKON Z 6_2";s:7:"caption";s:0:"";s:17:"created_timestamp";s:10:"1736045141";s:9:"copyright";s:0:"";s:12:"focal_length";s:2:"37";s:3:"iso";s:4:"1250";s:13:"shutter_speed";s:7:"0.00625";s:5:"title";s:0:"";s:11:"orientation";s:1:"1";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}s:14:"original_image";s:55:"05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1-.jpg";}');
INSERT INTO `wp_postmeta` VALUES (960,58,'_thumbnail_id',117);
INSERT INTO `wp_postmeta` VALUES (961,118,'_wp_attached_file','2026/09/05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1-1-1-scaled.jpg');
INSERT INTO `wp_postmeta` VALUES (962,118,'_wp_attachment_metadata','a:7:{s:5:"width";i:2560;s:6:"height";i:2213;s:4:"file";s:73:"2026/09/05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1-1-1-scaled.jpg";s:8:"filesize";i:1002251;s:5:"sizes";a:6:{s:6:"medium";a:5:{s:4:"file";s:66:"05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1-1-1-300x259.jpg";s:5:"width";i:300;s:6:"height";i:259;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:29465;}s:5:"large";a:5:{s:4:"file";s:67:"05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1-1-1-1024x885.jpg";s:5:"width";i:1024;s:6:"height";i:885;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:229549;}s:9:"thumbnail";a:5:{s:4:"file";s:66:"05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1-1-1-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:10361;}s:12:"medium_large";a:5:{s:4:"file";s:66:"05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1-1-1-768x664.jpg";s:5:"width";i:768;s:6:"height";i:664;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:142414;}s:9:"1536x1536";a:5:{s:4:"file";s:68:"05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1-1-1-1536x1328.jpg";s:5:"width";i:1536;s:6:"height";i:1328;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:442997;}s:9:"2048x2048";a:5:{s:4:"file";s:68:"05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1-1-1-2048x1770.jpg";s:5:"width";i:2048;s:6:"height";i:1770;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:704592;}}s:10:"image_meta";a:13:{s:8:"aperture";s:3:"6.3";s:6:"credit";s:0:"";s:6:"camera";s:11:"NIKON Z 6_2";s:7:"caption";s:0:"";s:17:"created_timestamp";s:10:"1736045141";s:9:"copyright";s:0:"";s:12:"focal_length";s:2:"37";s:3:"iso";s:4:"1250";s:13:"shutter_speed";s:7:"0.00625";s:5:"title";s:0:"";s:11:"orientation";s:1:"1";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}s:14:"original_image";s:58:"05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1-1-1.jpg";}');
INSERT INTO `wp_postmeta` VALUES (963,57,'_thumbnail_id',118);
INSERT INTO `wp_postmeta` VALUES (964,119,'_wp_attached_file','2026/09/05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1-1-2-scaled.jpg');
INSERT INTO `wp_postmeta` VALUES (965,119,'_wp_attachment_metadata','a:7:{s:5:"width";i:2560;s:6:"height";i:2213;s:4:"file";s:73:"2026/09/05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1-1-2-scaled.jpg";s:8:"filesize";i:1002251;s:5:"sizes";a:6:{s:6:"medium";a:5:{s:4:"file";s:66:"05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1-1-2-300x259.jpg";s:5:"width";i:300;s:6:"height";i:259;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:29465;}s:5:"large";a:5:{s:4:"file";s:67:"05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1-1-2-1024x885.jpg";s:5:"width";i:1024;s:6:"height";i:885;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:229549;}s:9:"thumbnail";a:5:{s:4:"file";s:66:"05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1-1-2-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:10361;}s:12:"medium_large";a:5:{s:4:"file";s:66:"05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1-1-2-768x664.jpg";s:5:"width";i:768;s:6:"height";i:664;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:142414;}s:9:"1536x1536";a:5:{s:4:"file";s:68:"05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1-1-2-1536x1328.jpg";s:5:"width";i:1536;s:6:"height";i:1328;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:442997;}s:9:"2048x2048";a:5:{s:4:"file";s:68:"05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1-1-2-2048x1770.jpg";s:5:"width";i:2048;s:6:"height";i:1770;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:704592;}}s:10:"image_meta";a:13:{s:8:"aperture";s:3:"6.3";s:6:"credit";s:0:"";s:6:"camera";s:11:"NIKON Z 6_2";s:7:"caption";s:0:"";s:17:"created_timestamp";s:10:"1736045141";s:9:"copyright";s:0:"";s:12:"focal_length";s:2:"37";s:3:"iso";s:4:"1250";s:13:"shutter_speed";s:7:"0.00625";s:5:"title";s:0:"";s:11:"orientation";s:1:"1";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}s:14:"original_image";s:58:"05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1-1-2.jpg";}');
INSERT INTO `wp_postmeta` VALUES (966,56,'_thumbnail_id',119);
INSERT INTO `wp_postmeta` VALUES (967,120,'_wp_attached_file','2026/09/05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1-1-3-scaled.jpg');
INSERT INTO `wp_postmeta` VALUES (968,120,'_wp_attachment_metadata','a:7:{s:5:"width";i:2560;s:6:"height";i:2213;s:4:"file";s:73:"2026/09/05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1-1-3-scaled.jpg";s:8:"filesize";i:1002251;s:5:"sizes";a:6:{s:6:"medium";a:5:{s:4:"file";s:66:"05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1-1-3-300x259.jpg";s:5:"width";i:300;s:6:"height";i:259;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:29465;}s:5:"large";a:5:{s:4:"file";s:67:"05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1-1-3-1024x885.jpg";s:5:"width";i:1024;s:6:"height";i:885;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:229549;}s:9:"thumbnail";a:5:{s:4:"file";s:66:"05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1-1-3-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:10361;}s:12:"medium_large";a:5:{s:4:"file";s:66:"05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1-1-3-768x664.jpg";s:5:"width";i:768;s:6:"height";i:664;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:142414;}s:9:"1536x1536";a:5:{s:4:"file";s:68:"05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1-1-3-1536x1328.jpg";s:5:"width";i:1536;s:6:"height";i:1328;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:442997;}s:9:"2048x2048";a:5:{s:4:"file";s:68:"05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1-1-3-2048x1770.jpg";s:5:"width";i:2048;s:6:"height";i:1770;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:704592;}}s:10:"image_meta";a:13:{s:8:"aperture";s:3:"6.3";s:6:"credit";s:0:"";s:6:"camera";s:11:"NIKON Z 6_2";s:7:"caption";s:0:"";s:17:"created_timestamp";s:10:"1736045141";s:9:"copyright";s:0:"";s:12:"focal_length";s:2:"37";s:3:"iso";s:4:"1250";s:13:"shutter_speed";s:7:"0.00625";s:5:"title";s:0:"";s:11:"orientation";s:1:"1";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}s:14:"original_image";s:58:"05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1-1-3.jpg";}');
INSERT INTO `wp_postmeta` VALUES (969,55,'_thumbnail_id',120);
INSERT INTO `wp_postmeta` VALUES (970,121,'_wp_attached_file','2026/09/18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1--scaled.jpg');
INSERT INTO `wp_postmeta` VALUES (971,121,'_wp_attachment_metadata','a:7:{s:5:"width";i:2560;s:6:"height";i:1981;s:4:"file";s:82:"2026/09/18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1--scaled.jpg";s:8:"filesize";i:718368;s:5:"sizes";a:6:{s:6:"medium";a:5:{s:4:"file";s:75:"18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1--300x232.jpg";s:5:"width";i:300;s:6:"height";i:232;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:25965;}s:5:"large";a:5:{s:4:"file";s:76:"18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1--1024x792.jpg";s:5:"width";i:1024;s:6:"height";i:792;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:200196;}s:9:"thumbnail";a:5:{s:4:"file";s:75:"18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1--150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:9983;}s:12:"medium_large";a:5:{s:4:"file";s:75:"18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1--768x594.jpg";s:5:"width";i:768;s:6:"height";i:594;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:129828;}s:9:"1536x1536";a:5:{s:4:"file";s:77:"18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1--1536x1188.jpg";s:5:"width";i:1536;s:6:"height";i:1188;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:355906;}s:9:"2048x2048";a:5:{s:4:"file";s:77:"18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1--2048x1584.jpg";s:5:"width";i:2048;s:6:"height";i:1584;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:529488;}}s:10:"image_meta";a:13:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"1";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}s:14:"original_image";s:67:"18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1-.jpg";}');
INSERT INTO `wp_postmeta` VALUES (972,54,'_thumbnail_id',121);
INSERT INTO `wp_postmeta` VALUES (973,122,'_wp_attached_file','2026/09/18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1-1-1-scaled.jpg');
INSERT INTO `wp_postmeta` VALUES (974,122,'_wp_attachment_metadata','a:7:{s:5:"width";i:2560;s:6:"height";i:1981;s:4:"file";s:85:"2026/09/18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1-1-1-scaled.jpg";s:8:"filesize";i:718368;s:5:"sizes";a:6:{s:6:"medium";a:5:{s:4:"file";s:78:"18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1-1-1-300x232.jpg";s:5:"width";i:300;s:6:"height";i:232;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:25965;}s:5:"large";a:5:{s:4:"file";s:79:"18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1-1-1-1024x792.jpg";s:5:"width";i:1024;s:6:"height";i:792;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:200196;}s:9:"thumbnail";a:5:{s:4:"file";s:78:"18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1-1-1-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:9983;}s:12:"medium_large";a:5:{s:4:"file";s:78:"18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1-1-1-768x594.jpg";s:5:"width";i:768;s:6:"height";i:594;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:129828;}s:9:"1536x1536";a:5:{s:4:"file";s:80:"18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1-1-1-1536x1188.jpg";s:5:"width";i:1536;s:6:"height";i:1188;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:355906;}s:9:"2048x2048";a:5:{s:4:"file";s:80:"18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1-1-1-2048x1584.jpg";s:5:"width";i:2048;s:6:"height";i:1584;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:529488;}}s:10:"image_meta";a:13:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"1";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}s:14:"original_image";s:70:"18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1-1-1.jpg";}');
INSERT INTO `wp_postmeta` VALUES (975,53,'_thumbnail_id',122);
INSERT INTO `wp_postmeta` VALUES (976,123,'_wp_attached_file','2026/09/18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1-1-2-scaled.jpg');
INSERT INTO `wp_postmeta` VALUES (977,123,'_wp_attachment_metadata','a:7:{s:5:"width";i:2560;s:6:"height";i:1981;s:4:"file";s:85:"2026/09/18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1-1-2-scaled.jpg";s:8:"filesize";i:718368;s:5:"sizes";a:6:{s:6:"medium";a:5:{s:4:"file";s:78:"18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1-1-2-300x232.jpg";s:5:"width";i:300;s:6:"height";i:232;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:25965;}s:5:"large";a:5:{s:4:"file";s:79:"18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1-1-2-1024x792.jpg";s:5:"width";i:1024;s:6:"height";i:792;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:200196;}s:9:"thumbnail";a:5:{s:4:"file";s:78:"18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1-1-2-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:9983;}s:12:"medium_large";a:5:{s:4:"file";s:78:"18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1-1-2-768x594.jpg";s:5:"width";i:768;s:6:"height";i:594;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:129828;}s:9:"1536x1536";a:5:{s:4:"file";s:80:"18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1-1-2-1536x1188.jpg";s:5:"width";i:1536;s:6:"height";i:1188;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:355906;}s:9:"2048x2048";a:5:{s:4:"file";s:80:"18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1-1-2-2048x1584.jpg";s:5:"width";i:2048;s:6:"height";i:1584;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:529488;}}s:10:"image_meta";a:13:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"1";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}s:14:"original_image";s:70:"18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1-1-2.jpg";}');
INSERT INTO `wp_postmeta` VALUES (978,52,'_thumbnail_id',123);
INSERT INTO `wp_postmeta` VALUES (979,124,'_wp_attached_file','2026/09/18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1-1-3-scaled.jpg');
INSERT INTO `wp_postmeta` VALUES (980,124,'_wp_attachment_metadata','a:7:{s:5:"width";i:2560;s:6:"height";i:1981;s:4:"file";s:85:"2026/09/18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1-1-3-scaled.jpg";s:8:"filesize";i:718368;s:5:"sizes";a:6:{s:6:"medium";a:5:{s:4:"file";s:78:"18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1-1-3-300x232.jpg";s:5:"width";i:300;s:6:"height";i:232;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:25965;}s:5:"large";a:5:{s:4:"file";s:79:"18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1-1-3-1024x792.jpg";s:5:"width";i:1024;s:6:"height";i:792;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:200196;}s:9:"thumbnail";a:5:{s:4:"file";s:78:"18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1-1-3-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:9983;}s:12:"medium_large";a:5:{s:4:"file";s:78:"18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1-1-3-768x594.jpg";s:5:"width";i:768;s:6:"height";i:594;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:129828;}s:9:"1536x1536";a:5:{s:4:"file";s:80:"18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1-1-3-1536x1188.jpg";s:5:"width";i:1536;s:6:"height";i:1188;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:355906;}s:9:"2048x2048";a:5:{s:4:"file";s:80:"18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1-1-3-2048x1584.jpg";s:5:"width";i:2048;s:6:"height";i:1584;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:529488;}}s:10:"image_meta";a:13:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"1";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}s:14:"original_image";s:70:"18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1-1-3.jpg";}');
INSERT INTO `wp_postmeta` VALUES (981,51,'_thumbnail_id',124);
INSERT INTO `wp_postmeta` VALUES (982,125,'_wp_attached_file','2026/09/18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1--scaled.jpg');
INSERT INTO `wp_postmeta` VALUES (983,125,'_wp_attachment_metadata','a:7:{s:5:"width";i:2560;s:6:"height";i:1707;s:4:"file";s:71:"2026/09/18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1--scaled.jpg";s:8:"filesize";i:913944;s:5:"sizes";a:6:{s:6:"medium";a:5:{s:4:"file";s:64:"18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1--300x200.jpg";s:5:"width";i:300;s:6:"height";i:200;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:25377;}s:5:"large";a:5:{s:4:"file";s:65:"18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1--1024x683.jpg";s:5:"width";i:1024;s:6:"height";i:683;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:202230;}s:9:"thumbnail";a:5:{s:4:"file";s:64:"18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1--150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:11209;}s:12:"medium_large";a:5:{s:4:"file";s:64:"18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1--768x512.jpg";s:5:"width";i:768;s:6:"height";i:512;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:124466;}s:9:"1536x1536";a:5:{s:4:"file";s:66:"18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1--1536x1024.jpg";s:5:"width";i:1536;s:6:"height";i:1024;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:392796;}s:9:"2048x2048";a:5:{s:4:"file";s:66:"18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1--2048x1365.jpg";s:5:"width";i:2048;s:6:"height";i:1365;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:630647;}}s:10:"image_meta";a:13:{s:8:"aperture";s:3:"5.6";s:6:"credit";s:0:"";s:6:"camera";s:6:"ZV-E10";s:7:"caption";s:0:"";s:17:"created_timestamp";s:10:"1737164343";s:9:"copyright";s:0:"";s:12:"focal_length";s:2:"27";s:3:"iso";s:4:"2000";s:13:"shutter_speed";s:5:"0.005";s:5:"title";s:0:"";s:11:"orientation";s:1:"1";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}s:14:"original_image";s:56:"18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1-.jpg";}');
INSERT INTO `wp_postmeta` VALUES (984,50,'_thumbnail_id',125);
INSERT INTO `wp_postmeta` VALUES (985,126,'_wp_attached_file','2026/09/18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1-1-1-scaled.jpg');
INSERT INTO `wp_postmeta` VALUES (986,126,'_wp_attachment_metadata','a:7:{s:5:"width";i:2560;s:6:"height";i:1707;s:4:"file";s:74:"2026/09/18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1-1-1-scaled.jpg";s:8:"filesize";i:913944;s:5:"sizes";a:6:{s:6:"medium";a:5:{s:4:"file";s:67:"18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1-1-1-300x200.jpg";s:5:"width";i:300;s:6:"height";i:200;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:25377;}s:5:"large";a:5:{s:4:"file";s:68:"18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1-1-1-1024x683.jpg";s:5:"width";i:1024;s:6:"height";i:683;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:202230;}s:9:"thumbnail";a:5:{s:4:"file";s:67:"18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1-1-1-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:11209;}s:12:"medium_large";a:5:{s:4:"file";s:67:"18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1-1-1-768x512.jpg";s:5:"width";i:768;s:6:"height";i:512;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:124466;}s:9:"1536x1536";a:5:{s:4:"file";s:69:"18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1-1-1-1536x1024.jpg";s:5:"width";i:1536;s:6:"height";i:1024;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:392796;}s:9:"2048x2048";a:5:{s:4:"file";s:69:"18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1-1-1-2048x1365.jpg";s:5:"width";i:2048;s:6:"height";i:1365;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:630647;}}s:10:"image_meta";a:13:{s:8:"aperture";s:3:"5.6";s:6:"credit";s:0:"";s:6:"camera";s:6:"ZV-E10";s:7:"caption";s:0:"";s:17:"created_timestamp";s:10:"1737164343";s:9:"copyright";s:0:"";s:12:"focal_length";s:2:"27";s:3:"iso";s:4:"2000";s:13:"shutter_speed";s:5:"0.005";s:5:"title";s:0:"";s:11:"orientation";s:1:"1";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}s:14:"original_image";s:59:"18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1-1-1.jpg";}');
INSERT INTO `wp_postmeta` VALUES (987,49,'_thumbnail_id',126);
INSERT INTO `wp_postmeta` VALUES (988,127,'_wp_attached_file','2026/09/18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1-1-2-scaled.jpg');
INSERT INTO `wp_postmeta` VALUES (989,127,'_wp_attachment_metadata','a:7:{s:5:"width";i:2560;s:6:"height";i:1707;s:4:"file";s:74:"2026/09/18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1-1-2-scaled.jpg";s:8:"filesize";i:913944;s:5:"sizes";a:6:{s:6:"medium";a:5:{s:4:"file";s:67:"18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1-1-2-300x200.jpg";s:5:"width";i:300;s:6:"height";i:200;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:25377;}s:5:"large";a:5:{s:4:"file";s:68:"18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1-1-2-1024x683.jpg";s:5:"width";i:1024;s:6:"height";i:683;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:202230;}s:9:"thumbnail";a:5:{s:4:"file";s:67:"18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1-1-2-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:11209;}s:12:"medium_large";a:5:{s:4:"file";s:67:"18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1-1-2-768x512.jpg";s:5:"width";i:768;s:6:"height";i:512;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:124466;}s:9:"1536x1536";a:5:{s:4:"file";s:69:"18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1-1-2-1536x1024.jpg";s:5:"width";i:1536;s:6:"height";i:1024;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:392796;}s:9:"2048x2048";a:5:{s:4:"file";s:69:"18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1-1-2-2048x1365.jpg";s:5:"width";i:2048;s:6:"height";i:1365;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:630647;}}s:10:"image_meta";a:13:{s:8:"aperture";s:3:"5.6";s:6:"credit";s:0:"";s:6:"camera";s:6:"ZV-E10";s:7:"caption";s:0:"";s:17:"created_timestamp";s:10:"1737164343";s:9:"copyright";s:0:"";s:12:"focal_length";s:2:"27";s:3:"iso";s:4:"2000";s:13:"shutter_speed";s:5:"0.005";s:5:"title";s:0:"";s:11:"orientation";s:1:"1";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}s:14:"original_image";s:59:"18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1-1-2.jpg";}');
INSERT INTO `wp_postmeta` VALUES (990,48,'_thumbnail_id',127);
INSERT INTO `wp_postmeta` VALUES (991,128,'_wp_attached_file','2026/09/18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1-1-3-scaled.jpg');
INSERT INTO `wp_postmeta` VALUES (992,128,'_wp_attachment_metadata','a:7:{s:5:"width";i:2560;s:6:"height";i:1707;s:4:"file";s:74:"2026/09/18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1-1-3-scaled.jpg";s:8:"filesize";i:913944;s:5:"sizes";a:6:{s:6:"medium";a:5:{s:4:"file";s:67:"18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1-1-3-300x200.jpg";s:5:"width";i:300;s:6:"height";i:200;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:25377;}s:5:"large";a:5:{s:4:"file";s:68:"18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1-1-3-1024x683.jpg";s:5:"width";i:1024;s:6:"height";i:683;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:202230;}s:9:"thumbnail";a:5:{s:4:"file";s:67:"18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1-1-3-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:11209;}s:12:"medium_large";a:5:{s:4:"file";s:67:"18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1-1-3-768x512.jpg";s:5:"width";i:768;s:6:"height";i:512;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:124466;}s:9:"1536x1536";a:5:{s:4:"file";s:69:"18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1-1-3-1536x1024.jpg";s:5:"width";i:1536;s:6:"height";i:1024;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:392796;}s:9:"2048x2048";a:5:{s:4:"file";s:69:"18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1-1-3-2048x1365.jpg";s:5:"width";i:2048;s:6:"height";i:1365;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:630647;}}s:10:"image_meta";a:13:{s:8:"aperture";s:3:"5.6";s:6:"credit";s:0:"";s:6:"camera";s:6:"ZV-E10";s:7:"caption";s:0:"";s:17:"created_timestamp";s:10:"1737164343";s:9:"copyright";s:0:"";s:12:"focal_length";s:2:"27";s:3:"iso";s:4:"2000";s:13:"shutter_speed";s:5:"0.005";s:5:"title";s:0:"";s:11:"orientation";s:1:"1";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}s:14:"original_image";s:59:"18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1-1-3.jpg";}');
INSERT INTO `wp_postmeta` VALUES (993,47,'_thumbnail_id',128);
INSERT INTO `wp_postmeta` VALUES (994,129,'_wp_attached_file','2026/09/05-01-25-kutumba-milana-rysri-jayanagar-3--scaled.jpg');
INSERT INTO `wp_postmeta` VALUES (995,129,'_wp_attachment_metadata','a:7:{s:5:"width";i:2560;s:6:"height";i:1586;s:4:"file";s:61:"2026/09/05-01-25-kutumba-milana-rysri-jayanagar-3--scaled.jpg";s:8:"filesize";i:1093483;s:5:"sizes";a:6:{s:6:"medium";a:5:{s:4:"file";s:54:"05-01-25-kutumba-milana-rysri-jayanagar-3--300x186.jpg";s:5:"width";i:300;s:6:"height";i:186;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:29985;}s:5:"large";a:5:{s:4:"file";s:55:"05-01-25-kutumba-milana-rysri-jayanagar-3--1024x635.jpg";s:5:"width";i:1024;s:6:"height";i:635;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:251190;}s:9:"thumbnail";a:5:{s:4:"file";s:54:"05-01-25-kutumba-milana-rysri-jayanagar-3--150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:13224;}s:12:"medium_large";a:5:{s:4:"file";s:54:"05-01-25-kutumba-milana-rysri-jayanagar-3--768x476.jpg";s:5:"width";i:768;s:6:"height";i:476;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:153007;}s:9:"1536x1536";a:5:{s:4:"file";s:55:"05-01-25-kutumba-milana-rysri-jayanagar-3--1536x952.jpg";s:5:"width";i:1536;s:6:"height";i:952;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:492819;}s:9:"2048x2048";a:5:{s:4:"file";s:56:"05-01-25-kutumba-milana-rysri-jayanagar-3--2048x1269.jpg";s:5:"width";i:2048;s:6:"height";i:1269;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:779762;}}s:10:"image_meta";a:13:{s:8:"aperture";s:1:"4";s:6:"credit";s:0:"";s:6:"camera";s:11:"NIKON Z 6_2";s:7:"caption";s:0:"";s:17:"created_timestamp";s:10:"1736091541";s:9:"copyright";s:0:"";s:12:"focal_length";s:2:"24";s:3:"iso";s:4:"4000";s:13:"shutter_speed";s:17:"0.016666666666667";s:5:"title";s:0:"";s:11:"orientation";s:1:"1";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}s:14:"original_image";s:46:"05-01-25-kutumba-milana-rysri-jayanagar-3-.jpg";}');
INSERT INTO `wp_postmeta` VALUES (996,46,'_thumbnail_id',129);
INSERT INTO `wp_postmeta` VALUES (997,130,'_wp_attached_file','2026/09/05-01-25-kutumba-milana-rysri-jayanagar-3-1-1-scaled.jpg');
INSERT INTO `wp_postmeta` VALUES (998,130,'_wp_attachment_metadata','a:7:{s:5:"width";i:2560;s:6:"height";i:1586;s:4:"file";s:64:"2026/09/05-01-25-kutumba-milana-rysri-jayanagar-3-1-1-scaled.jpg";s:8:"filesize";i:1093483;s:5:"sizes";a:6:{s:6:"medium";a:5:{s:4:"file";s:57:"05-01-25-kutumba-milana-rysri-jayanagar-3-1-1-300x186.jpg";s:5:"width";i:300;s:6:"height";i:186;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:29985;}s:5:"large";a:5:{s:4:"file";s:58:"05-01-25-kutumba-milana-rysri-jayanagar-3-1-1-1024x635.jpg";s:5:"width";i:1024;s:6:"height";i:635;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:251190;}s:9:"thumbnail";a:5:{s:4:"file";s:57:"05-01-25-kutumba-milana-rysri-jayanagar-3-1-1-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:13224;}s:12:"medium_large";a:5:{s:4:"file";s:57:"05-01-25-kutumba-milana-rysri-jayanagar-3-1-1-768x476.jpg";s:5:"width";i:768;s:6:"height";i:476;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:153007;}s:9:"1536x1536";a:5:{s:4:"file";s:58:"05-01-25-kutumba-milana-rysri-jayanagar-3-1-1-1536x952.jpg";s:5:"width";i:1536;s:6:"height";i:952;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:492819;}s:9:"2048x2048";a:5:{s:4:"file";s:59:"05-01-25-kutumba-milana-rysri-jayanagar-3-1-1-2048x1269.jpg";s:5:"width";i:2048;s:6:"height";i:1269;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:779762;}}s:10:"image_meta";a:13:{s:8:"aperture";s:1:"4";s:6:"credit";s:0:"";s:6:"camera";s:11:"NIKON Z 6_2";s:7:"caption";s:0:"";s:17:"created_timestamp";s:10:"1736091541";s:9:"copyright";s:0:"";s:12:"focal_length";s:2:"24";s:3:"iso";s:4:"4000";s:13:"shutter_speed";s:17:"0.016666666666667";s:5:"title";s:0:"";s:11:"orientation";s:1:"1";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}s:14:"original_image";s:49:"05-01-25-kutumba-milana-rysri-jayanagar-3-1-1.jpg";}');
INSERT INTO `wp_postmeta` VALUES (999,45,'_thumbnail_id',130);
INSERT INTO `wp_postmeta` VALUES (1000,131,'_wp_attached_file','2026/09/05-01-25-kutumba-milana-rysri-jayanagar-3-1-2-scaled.jpg');
INSERT INTO `wp_postmeta` VALUES (1001,131,'_wp_attachment_metadata','a:7:{s:5:"width";i:2560;s:6:"height";i:1586;s:4:"file";s:64:"2026/09/05-01-25-kutumba-milana-rysri-jayanagar-3-1-2-scaled.jpg";s:8:"filesize";i:1093483;s:5:"sizes";a:6:{s:6:"medium";a:5:{s:4:"file";s:57:"05-01-25-kutumba-milana-rysri-jayanagar-3-1-2-300x186.jpg";s:5:"width";i:300;s:6:"height";i:186;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:29985;}s:5:"large";a:5:{s:4:"file";s:58:"05-01-25-kutumba-milana-rysri-jayanagar-3-1-2-1024x635.jpg";s:5:"width";i:1024;s:6:"height";i:635;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:251190;}s:9:"thumbnail";a:5:{s:4:"file";s:57:"05-01-25-kutumba-milana-rysri-jayanagar-3-1-2-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:13224;}s:12:"medium_large";a:5:{s:4:"file";s:57:"05-01-25-kutumba-milana-rysri-jayanagar-3-1-2-768x476.jpg";s:5:"width";i:768;s:6:"height";i:476;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:153007;}s:9:"1536x1536";a:5:{s:4:"file";s:58:"05-01-25-kutumba-milana-rysri-jayanagar-3-1-2-1536x952.jpg";s:5:"width";i:1536;s:6:"height";i:952;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:492819;}s:9:"2048x2048";a:5:{s:4:"file";s:59:"05-01-25-kutumba-milana-rysri-jayanagar-3-1-2-2048x1269.jpg";s:5:"width";i:2048;s:6:"height";i:1269;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:779762;}}s:10:"image_meta";a:13:{s:8:"aperture";s:1:"4";s:6:"credit";s:0:"";s:6:"camera";s:11:"NIKON Z 6_2";s:7:"caption";s:0:"";s:17:"created_timestamp";s:10:"1736091541";s:9:"copyright";s:0:"";s:12:"focal_length";s:2:"24";s:3:"iso";s:4:"4000";s:13:"shutter_speed";s:17:"0.016666666666667";s:5:"title";s:0:"";s:11:"orientation";s:1:"1";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}s:14:"original_image";s:49:"05-01-25-kutumba-milana-rysri-jayanagar-3-1-2.jpg";}');
INSERT INTO `wp_postmeta` VALUES (1002,44,'_thumbnail_id',131);
INSERT INTO `wp_postmeta` VALUES (1003,132,'_wp_attached_file','2026/09/05-01-25-kutumba-milana-rysri-jayanagar-3-1-3-scaled.jpg');
INSERT INTO `wp_postmeta` VALUES (1004,132,'_wp_attachment_metadata','a:7:{s:5:"width";i:2560;s:6:"height";i:1586;s:4:"file";s:64:"2026/09/05-01-25-kutumba-milana-rysri-jayanagar-3-1-3-scaled.jpg";s:8:"filesize";i:1093483;s:5:"sizes";a:6:{s:6:"medium";a:5:{s:4:"file";s:57:"05-01-25-kutumba-milana-rysri-jayanagar-3-1-3-300x186.jpg";s:5:"width";i:300;s:6:"height";i:186;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:29985;}s:5:"large";a:5:{s:4:"file";s:58:"05-01-25-kutumba-milana-rysri-jayanagar-3-1-3-1024x635.jpg";s:5:"width";i:1024;s:6:"height";i:635;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:251190;}s:9:"thumbnail";a:5:{s:4:"file";s:57:"05-01-25-kutumba-milana-rysri-jayanagar-3-1-3-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:13224;}s:12:"medium_large";a:5:{s:4:"file";s:57:"05-01-25-kutumba-milana-rysri-jayanagar-3-1-3-768x476.jpg";s:5:"width";i:768;s:6:"height";i:476;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:153007;}s:9:"1536x1536";a:5:{s:4:"file";s:58:"05-01-25-kutumba-milana-rysri-jayanagar-3-1-3-1536x952.jpg";s:5:"width";i:1536;s:6:"height";i:952;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:492819;}s:9:"2048x2048";a:5:{s:4:"file";s:59:"05-01-25-kutumba-milana-rysri-jayanagar-3-1-3-2048x1269.jpg";s:5:"width";i:2048;s:6:"height";i:1269;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:779762;}}s:10:"image_meta";a:13:{s:8:"aperture";s:1:"4";s:6:"credit";s:0:"";s:6:"camera";s:11:"NIKON Z 6_2";s:7:"caption";s:0:"";s:17:"created_timestamp";s:10:"1736091541";s:9:"copyright";s:0:"";s:12:"focal_length";s:2:"24";s:3:"iso";s:4:"4000";s:13:"shutter_speed";s:17:"0.016666666666667";s:5:"title";s:0:"";s:11:"orientation";s:1:"1";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}s:14:"original_image";s:49:"05-01-25-kutumba-milana-rysri-jayanagar-3-1-3.jpg";}');
INSERT INTO `wp_postmeta` VALUES (1005,43,'_thumbnail_id',132);
INSERT INTO `wp_postmeta` VALUES (1574,43,'badge','Foundational');
INSERT INTO `wp_postmeta` VALUES (1575,43,'_badge','field_a_badge');
INSERT INTO `wp_postmeta` VALUES (1576,43,'description','Gentle joint mobility movements (Sukshma Vyayama), fundamental standing and sitting asanas, basic pranayama, and guided Shavasana relaxation.');
INSERT INTO `wp_postmeta` VALUES (1577,43,'_description','');
INSERT INTO `wp_postmeta` VALUES (1578,43,'centers_text','Jayanagar, Basavanagudi, Malleswaram, Vijayanagar, Indiranagar, Whitefield, HSR Layout, JP Nagar, Sahakarnagar');
INSERT INTO `wp_postmeta` VALUES (1579,43,'_centers_text','');
INSERT INTO `wp_postmeta` VALUES (1580,43,'_batches_text','');
INSERT INTO `wp_postmeta` VALUES (1581,43,'duration_text','60 Mins / Class | 3-Month Foundation Course');
INSERT INTO `wp_postmeta` VALUES (1582,43,'_duration_text','');
INSERT INTO `wp_postmeta` VALUES (1583,43,'_frequency_text','');
INSERT INTO `wp_postmeta` VALUES (1584,43,'eligibility_text','Beginners & All Age Groups (Ages 12+)');
INSERT INTO `wp_postmeta` VALUES (1585,43,'_eligibility_text','');
INSERT INTO `wp_postmeta` VALUES (1586,44,'badge','Daily Batches');
INSERT INTO `wp_postmeta` VALUES (1587,44,'_badge','field_a_badge');
INSERT INTO `wp_postmeta` VALUES (1588,44,'description','Comprehensive daily practice incorporating dynamic Surya Namaskar cycles, posture endurance, core strength, flexibility, and vital energy pranayama.');
INSERT INTO `wp_postmeta` VALUES (1589,44,'_description','');
INSERT INTO `wp_postmeta` VALUES (1590,44,'centers_text','Available at all 11 Rashtrotthana Centers across Bengaluru');
INSERT INTO `wp_postmeta` VALUES (1591,44,'_centers_text','');
INSERT INTO `wp_postmeta` VALUES (1592,44,'_batches_text','');
INSERT INTO `wp_postmeta` VALUES (1593,44,'duration_text','60 Mins / Class | Ongoing Monthly Enrollment');
INSERT INTO `wp_postmeta` VALUES (1594,44,'_duration_text','');
INSERT INTO `wp_postmeta` VALUES (1595,44,'_frequency_text','');
INSERT INTO `wp_postmeta` VALUES (1596,44,'eligibility_text','All practitioners seeking sustained daily stamina & wellness');
INSERT INTO `wp_postmeta` VALUES (1597,44,'_eligibility_text','');
INSERT INTO `wp_postmeta` VALUES (1598,45,'badge','Therapeutic');
INSERT INTO `wp_postmeta` VALUES (1599,45,'_badge','field_a_badge');
INSERT INTO `wp_postmeta` VALUES (1600,45,'description','Customized clinical yoga modules addressing chronic lumbar and cervical back pain, postural correction, diabetes, hypertension, and workplace stress.');
INSERT INTO `wp_postmeta` VALUES (1601,45,'_description','');
INSERT INTO `wp_postmeta` VALUES (1602,45,'centers_text','Jayanagar, Basavanagudi, Malleswaram, Banashankari, Vijayanagar, JP Nagar, Sahakarnagar, RT Nagar');
INSERT INTO `wp_postmeta` VALUES (1603,45,'_centers_text','');
INSERT INTO `wp_postmeta` VALUES (1604,45,'_batches_text','');
INSERT INTO `wp_postmeta` VALUES (1605,45,'duration_text','60 Mins / Session | Tailored 12-Week Recovery Regimen');
INSERT INTO `wp_postmeta` VALUES (1606,45,'_duration_text','');
INSERT INTO `wp_postmeta` VALUES (1607,45,'frequency_text','4 Days / Week (Mon, Wed, Fri & Sat)');
INSERT INTO `wp_postmeta` VALUES (1608,45,'_frequency_text','');
INSERT INTO `wp_postmeta` VALUES (1609,45,'eligibility_text','Individuals with chronic ailments or doctor-recommended therapy');
INSERT INTO `wp_postmeta` VALUES (1610,45,'_eligibility_text','');
INSERT INTO `wp_postmeta` VALUES (1611,46,'badge','Specialized Care');
INSERT INTO `wp_postmeta` VALUES (1612,46,'_badge','field_a_badge');
INSERT INTO `wp_postmeta` VALUES (1613,46,'description','Safe, nurturing prenatal movements, pelvic floor strengthening, breath coordination, and restorative relaxation supporting maternal wellness.');
INSERT INTO `wp_postmeta` VALUES (1614,46,'_description','');
INSERT INTO `wp_postmeta` VALUES (1615,46,'centers_text','Jayanagar, Basavanagudi, Chandra Layout, Malleswaram, Indiranagar');
INSERT INTO `wp_postmeta` VALUES (1616,46,'_centers_text','');
INSERT INTO `wp_postmeta` VALUES (1617,46,'_batches_text','');
INSERT INTO `wp_postmeta` VALUES (1618,46,'duration_text','60 Mins / Class | Trimester-Wise Supervised Modules');
INSERT INTO `wp_postmeta` VALUES (1619,46,'_duration_text','');
INSERT INTO `wp_postmeta` VALUES (1620,46,'frequency_text','3 Days / Week (Mon, Wed, Fri)');
INSERT INTO `wp_postmeta` VALUES (1621,46,'_frequency_text','');
INSERT INTO `wp_postmeta` VALUES (1622,46,'eligibility_text','Expectant mothers from 2nd trimester (Medical clearance required)');
INSERT INTO `wp_postmeta` VALUES (1623,46,'_eligibility_text','');
INSERT INTO `wp_postmeta` VALUES (1624,47,'badge','Classical Vocal');
INSERT INTO `wp_postmeta` VALUES (1625,47,'_badge','field_a_badge');
INSERT INTO `wp_postmeta` VALUES (1626,47,'description','Traditional Swara practice, Sarali, Janti varases, Geethams, and sacred Keerthanas rooted in sacred ragas, talas, and classic compositions.');
INSERT INTO `wp_postmeta` VALUES (1627,47,'_description','');
INSERT INTO `wp_postmeta` VALUES (1628,47,'centers_text','Jayanagar, Basavanagudi, Malleswaram, Vijayanagar, Padmanabhanagar');
INSERT INTO `wp_postmeta` VALUES (1629,47,'_centers_text','');
INSERT INTO `wp_postmeta` VALUES (1630,47,'_batches_text','');
INSERT INTO `wp_postmeta` VALUES (1631,47,'duration_text','60 Mins / Class | Annual Examination & Certification');
INSERT INTO `wp_postmeta` VALUES (1632,47,'_duration_text','');
INSERT INTO `wp_postmeta` VALUES (1633,47,'frequency_text','2 to 3 Days / Week');
INSERT INTO `wp_postmeta` VALUES (1634,47,'_frequency_text','');
INSERT INTO `wp_postmeta` VALUES (1635,47,'eligibility_text','Ages 6+ & Adults (Beginner to Senior Vidwat)');
INSERT INTO `wp_postmeta` VALUES (1636,47,'_eligibility_text','');
INSERT INTO `wp_postmeta` VALUES (1637,48,'badge','Instrumental');
INSERT INTO `wp_postmeta` VALUES (1638,48,'_badge','field_a_badge');
INSERT INTO `wp_postmeta` VALUES (1639,48,'description','Structured finger dexterity training covering foundational notations, western chord theory, and Indian devotional and melodic pieces.');
INSERT INTO `wp_postmeta` VALUES (1640,48,'_description','');
INSERT INTO `wp_postmeta` VALUES (1641,48,'centers_text','Malleswaram, Jayanagar, Basavanagudi, Vijayanagar, Yelahanka');
INSERT INTO `wp_postmeta` VALUES (1642,48,'_centers_text','');
INSERT INTO `wp_postmeta` VALUES (1643,48,'_batches_text','');
INSERT INTO `wp_postmeta` VALUES (1644,48,'duration_text','60 Mins / Class | Grade 1 to 8 Structured Syllabi');
INSERT INTO `wp_postmeta` VALUES (1645,48,'_duration_text','');
INSERT INTO `wp_postmeta` VALUES (1646,48,'frequency_text','2 Days / Week');
INSERT INTO `wp_postmeta` VALUES (1647,48,'_frequency_text','');
INSERT INTO `wp_postmeta` VALUES (1648,48,'eligibility_text','Ages 7+ & Adults (Instruments provided in studio)');
INSERT INTO `wp_postmeta` VALUES (1649,48,'_eligibility_text','');
INSERT INTO `wp_postmeta` VALUES (1650,49,'badge','Vocal');
INSERT INTO `wp_postmeta` VALUES (1651,49,'_badge','field_a_badge');
INSERT INTO `wp_postmeta` VALUES (1652,49,'description','Soulful rendition of Kannada Bhavageethe, devotionals, Dasa Sahitya, and cultural melodies with lyrical expression and voice culture.');
INSERT INTO `wp_postmeta` VALUES (1653,49,'_description','');
INSERT INTO `wp_postmeta` VALUES (1654,49,'centers_text','Basavanagudi, Jayanagar, Malleswaram, Banashankari');
INSERT INTO `wp_postmeta` VALUES (1655,49,'_centers_text','');
INSERT INTO `wp_postmeta` VALUES (1656,49,'_batches_text','');
INSERT INTO `wp_postmeta` VALUES (1657,49,'duration_text','60 Mins / Class | 6-Month Certificate Course');
INSERT INTO `wp_postmeta` VALUES (1658,49,'_duration_text','');
INSERT INTO `wp_postmeta` VALUES (1659,49,'frequency_text','2 Days / Week (Friday & Saturday)');
INSERT INTO `wp_postmeta` VALUES (1660,49,'_frequency_text','');
INSERT INTO `wp_postmeta` VALUES (1661,49,'eligibility_text','Open to all music enthusiasts (Ages 8+)');
INSERT INTO `wp_postmeta` VALUES (1662,49,'_eligibility_text','');
INSERT INTO `wp_postmeta` VALUES (1663,50,'badge','Instrumental');
INSERT INTO `wp_postmeta` VALUES (1664,50,'_badge','field_a_badge');
INSERT INTO `wp_postmeta` VALUES (1665,50,'description','Bamboo flute training starting from fundamental breath control, blowing technique, and finger placement to classical ragas and improvisations.');
INSERT INTO `wp_postmeta` VALUES (1666,50,'_description','');
INSERT INTO `wp_postmeta` VALUES (1667,50,'centers_text','Malleswaram, Jayanagar, Basavanagudi');
INSERT INTO `wp_postmeta` VALUES (1668,50,'_centers_text','');
INSERT INTO `wp_postmeta` VALUES (1669,50,'_batches_text','');
INSERT INTO `wp_postmeta` VALUES (1670,50,'duration_text','90 Mins / Class | Traditional Guru-Shishya Guidance');
INSERT INTO `wp_postmeta` VALUES (1671,50,'_duration_text','');
INSERT INTO `wp_postmeta` VALUES (1672,50,'frequency_text','2 Days / Week (Saturday & Sunday)');
INSERT INTO `wp_postmeta` VALUES (1673,50,'_frequency_text','');
INSERT INTO `wp_postmeta` VALUES (1674,50,'eligibility_text','Ages 10+ with dedication to wind instruments');
INSERT INTO `wp_postmeta` VALUES (1675,50,'_eligibility_text','');
INSERT INTO `wp_postmeta` VALUES (1676,51,'badge','Classical');
INSERT INTO `wp_postmeta` VALUES (1677,51,'_badge','field_a_badge');
INSERT INTO `wp_postmeta` VALUES (1678,51,'description','Sacred classical Indian dance cultivating precise footwork, adavus, hastamudras, rhythmic tala patterns, and expressive abhinaya storytelling.');
INSERT INTO `wp_postmeta` VALUES (1679,51,'_description','');
INSERT INTO `wp_postmeta` VALUES (1680,51,'centers_text','Basavanagudi, Jayanagar, Malleswaram, Mahalakshmi Layout, Vijayanagar');
INSERT INTO `wp_postmeta` VALUES (1681,51,'_centers_text','');
INSERT INTO `wp_postmeta` VALUES (1682,51,'_batches_text','');
INSERT INTO `wp_postmeta` VALUES (1683,51,'duration_text','60 Mins / Class | Alankar to Rangapravesha Certification');
INSERT INTO `wp_postmeta` VALUES (1684,51,'_duration_text','');
INSERT INTO `wp_postmeta` VALUES (1685,51,'frequency_text','3 Days / Week');
INSERT INTO `wp_postmeta` VALUES (1686,51,'_frequency_text','');
INSERT INTO `wp_postmeta` VALUES (1687,51,'eligibility_text','Ages 5+ to Adults');
INSERT INTO `wp_postmeta` VALUES (1688,51,'_eligibility_text','');
INSERT INTO `wp_postmeta` VALUES (1689,52,'badge','Classical');
INSERT INTO `wp_postmeta` VALUES (1690,52,'_badge','field_a_badge');
INSERT INTO `wp_postmeta` VALUES (1691,52,'description','North Indian classical dance celebrated for intricate ghungroo footwork (Tatkar), swift pirouettes (Chakkars), padhant recitation, and lyrical Radha-Krishna themes.');
INSERT INTO `wp_postmeta` VALUES (1692,52,'_description','');
INSERT INTO `wp_postmeta` VALUES (1693,52,'centers_text','Malleswaram, Indiranagar, Jayanagar');
INSERT INTO `wp_postmeta` VALUES (1694,52,'_centers_text','');
INSERT INTO `wp_postmeta` VALUES (1695,52,'_batches_text','');
INSERT INTO `wp_postmeta` VALUES (1696,52,'duration_text','75 Mins / Class | Systematic Gharana Pedagogy');
INSERT INTO `wp_postmeta` VALUES (1697,52,'_duration_text','');
INSERT INTO `wp_postmeta` VALUES (1698,52,'frequency_text','2 Days / Week');
INSERT INTO `wp_postmeta` VALUES (1699,52,'_frequency_text','');
INSERT INTO `wp_postmeta` VALUES (1700,52,'eligibility_text','Ages 7+ & Adults');
INSERT INTO `wp_postmeta` VALUES (1701,52,'_eligibility_text','');
INSERT INTO `wp_postmeta` VALUES (1702,53,'badge','Folk Heritage');
INSERT INTO `wp_postmeta` VALUES (1703,53,'_badge','field_a_badge');
INSERT INTO `wp_postmeta` VALUES (1704,53,'description','Vibrant regional folk dances of Karnataka and India including Kolata, Dollu Kunitha rhythms, harvest festivities, and group synchronization.');
INSERT INTO `wp_postmeta` VALUES (1705,53,'_description','');
INSERT INTO `wp_postmeta` VALUES (1706,53,'centers_text','Basavanagudi, Malleswaram, Padmanabhanagar, Yelahanka');
INSERT INTO `wp_postmeta` VALUES (1707,53,'_centers_text','');
INSERT INTO `wp_postmeta` VALUES (1708,53,'_batches_text','');
INSERT INTO `wp_postmeta` VALUES (1709,53,'duration_text','90 Mins / Class | Festival Showcase & Annual Production');
INSERT INTO `wp_postmeta` VALUES (1710,53,'_duration_text','');
INSERT INTO `wp_postmeta` VALUES (1711,53,'frequency_text','2 Days / Week (Weekends)');
INSERT INTO `wp_postmeta` VALUES (1712,53,'_frequency_text','');
INSERT INTO `wp_postmeta` VALUES (1713,53,'eligibility_text','Ages 6 to 18');
INSERT INTO `wp_postmeta` VALUES (1714,53,'_eligibility_text','');
INSERT INTO `wp_postmeta` VALUES (1715,54,'badge','Modern Movement');
INSERT INTO `wp_postmeta` VALUES (1716,54,'_badge','field_a_badge');
INSERT INTO `wp_postmeta` VALUES (1717,54,'description','Expressive modern movement combining bodily agility, floorwork, rhythmic musicality, creative storytelling, and stamina building.');
INSERT INTO `wp_postmeta` VALUES (1718,54,'_description','');
INSERT INTO `wp_postmeta` VALUES (1719,54,'centers_text','Indiranagar, Koramangala, Whitefield, HSR Layout');
INSERT INTO `wp_postmeta` VALUES (1720,54,'_centers_text','');
INSERT INTO `wp_postmeta` VALUES (1721,54,'_batches_text','');
INSERT INTO `wp_postmeta` VALUES (1722,54,'duration_text','75 Mins / Class | Foundation & Intermediate Levels');
INSERT INTO `wp_postmeta` VALUES (1723,54,'_duration_text','');
INSERT INTO `wp_postmeta` VALUES (1724,54,'frequency_text','2 to 3 Days / Week');
INSERT INTO `wp_postmeta` VALUES (1725,54,'_frequency_text','');
INSERT INTO `wp_postmeta` VALUES (1726,54,'eligibility_text','Teens & Young Adults (Ages 12+)');
INSERT INTO `wp_postmeta` VALUES (1727,54,'_eligibility_text','');
INSERT INTO `wp_postmeta` VALUES (1728,55,'badge','All Belts');
INSERT INTO `wp_postmeta` VALUES (1729,55,'_badge','field_a_badge');
INSERT INTO `wp_postmeta` VALUES (1730,55,'description','Speed, power, self-defence katas, bunkai analysis, and official belt grading examinations conducted under certified black belt masters.');
INSERT INTO `wp_postmeta` VALUES (1731,55,'_description','');
INSERT INTO `wp_postmeta` VALUES (1732,55,'centers_text','Marathahalli, Sahakarnagar, Vijayanagar, Yelahanka, Kengeri, Rajajinagar');
INSERT INTO `wp_postmeta` VALUES (1733,55,'_centers_text','');
INSERT INTO `wp_postmeta` VALUES (1734,55,'_batches_text','');
INSERT INTO `wp_postmeta` VALUES (1735,55,'duration_text','75 Mins / Class | Continuous Belt Grading Cycle');
INSERT INTO `wp_postmeta` VALUES (1736,55,'_duration_text','');
INSERT INTO `wp_postmeta` VALUES (1737,55,'frequency_text','3 Days / Week (Tue, Thu, Sat)');
INSERT INTO `wp_postmeta` VALUES (1738,55,'_frequency_text','');
INSERT INTO `wp_postmeta` VALUES (1739,55,'eligibility_text','Ages 6+ to Adults');
INSERT INTO `wp_postmeta` VALUES (1740,55,'_eligibility_text','');
INSERT INTO `wp_postmeta` VALUES (1741,56,'badge','Agility & Sparring');
INSERT INTO `wp_postmeta` VALUES (1742,56,'_badge','field_a_badge');
INSERT INTO `wp_postmeta` VALUES (1743,56,'description','Dynamic high kicks, core agility, mental fortitude, speed breaking, and Olympic-style sparring drills with protective gear.');
INSERT INTO `wp_postmeta` VALUES (1744,56,'_description','');
INSERT INTO `wp_postmeta` VALUES (1745,56,'centers_text','Sahakarnagar, Marathahalli, Bellandur, HSR Layout');
INSERT INTO `wp_postmeta` VALUES (1746,56,'_centers_text','');
INSERT INTO `wp_postmeta` VALUES (1747,56,'_batches_text','');
INSERT INTO `wp_postmeta` VALUES (1748,56,'duration_text','60 Mins / Class | Olympic Sparring Curriculum');
INSERT INTO `wp_postmeta` VALUES (1749,56,'_duration_text','');
INSERT INTO `wp_postmeta` VALUES (1750,56,'frequency_text','3 Days / Week (Mon, Wed, Fri)');
INSERT INTO `wp_postmeta` VALUES (1751,56,'_frequency_text','');
INSERT INTO `wp_postmeta` VALUES (1752,56,'eligibility_text','Ages 7+ to Youth');
INSERT INTO `wp_postmeta` VALUES (1753,56,'_eligibility_text','');
INSERT INTO `wp_postmeta` VALUES (1754,57,'badge','Traditional');
INSERT INTO `wp_postmeta` VALUES (1755,57,'_badge','field_a_badge');
INSERT INTO `wp_postmeta` VALUES (1756,57,'description','Ancient Indian warrior art emphasizing animal postures (Ashta Vadivu), body flexibility, oil massages, fluid footwork, and traditional wooden staff forms.');
INSERT INTO `wp_postmeta` VALUES (1757,57,'_description','');
INSERT INTO `wp_postmeta` VALUES (1758,57,'centers_text','Basavanagudi, Malleswaram, Indiranagar');
INSERT INTO `wp_postmeta` VALUES (1759,57,'_centers_text','');
INSERT INTO `wp_postmeta` VALUES (1760,57,'_batches_text','');
INSERT INTO `wp_postmeta` VALUES (1761,57,'duration_text','90 Mins / Class | Body Conditioning & Combat Conditioning');
INSERT INTO `wp_postmeta` VALUES (1762,57,'_duration_text','');
INSERT INTO `wp_postmeta` VALUES (1763,57,'frequency_text','3 Days / Week');
INSERT INTO `wp_postmeta` VALUES (1764,57,'_frequency_text','');
INSERT INTO `wp_postmeta` VALUES (1765,57,'eligibility_text','Ages 10+ (Physical readiness required)');
INSERT INTO `wp_postmeta` VALUES (1766,57,'_eligibility_text','');
INSERT INTO `wp_postmeta` VALUES (1767,58,'badge','Modular Workshops');
INSERT INTO `wp_postmeta` VALUES (1768,58,'_badge','field_a_badge');
INSERT INTO `wp_postmeta` VALUES (1769,58,'description','Practical situational awareness, wrist release techniques, evasion tactics, and reflexive defence strategies designed for real-world personal safety.');
INSERT INTO `wp_postmeta` VALUES (1770,58,'_description','');
INSERT INTO `wp_postmeta` VALUES (1771,58,'centers_text','Available across all 12 Centers (Special modular batches)');
INSERT INTO `wp_postmeta` VALUES (1772,58,'_centers_text','');
INSERT INTO `wp_postmeta` VALUES (1773,58,'_batches_text','');
INSERT INTO `wp_postmeta` VALUES (1774,58,'duration_text','4-Week Intensive Certificate Bootcamp');
INSERT INTO `wp_postmeta` VALUES (1775,58,'_duration_text','');
INSERT INTO `wp_postmeta` VALUES (1776,58,'frequency_text','Weekend Sessions');
INSERT INTO `wp_postmeta` VALUES (1777,58,'_frequency_text','');
INSERT INTO `wp_postmeta` VALUES (1778,58,'eligibility_text','Women, College Students & Corporate Professionals');
INSERT INTO `wp_postmeta` VALUES (1779,58,'_eligibility_text','');
INSERT INTO `wp_postmeta` VALUES (1780,59,'badge','Ages 5-12');
INSERT INTO `wp_postmeta` VALUES (1781,59,'_badge','field_a_badge');
INSERT INTO `wp_postmeta` VALUES (1782,59,'description','Interactive, playful Sanskrit learning through joyful stories, rhymes, shlokas, conversational dialogues, and cultural value games.');
INSERT INTO `wp_postmeta` VALUES (1783,59,'_description','');
INSERT INTO `wp_postmeta` VALUES (1784,59,'centers_text','Jayanagar, Basavanagudi, Malleswaram, Vijayanagar, Rajajinagar, Padmanabhanagar');
INSERT INTO `wp_postmeta` VALUES (1785,59,'_centers_text','');
INSERT INTO `wp_postmeta` VALUES (1786,59,'_batches_text','');
INSERT INTO `wp_postmeta` VALUES (1787,59,'duration_text','90 Mins / Class | Annual Academic Cycle');
INSERT INTO `wp_postmeta` VALUES (1788,59,'_duration_text','');
INSERT INTO `wp_postmeta` VALUES (1789,59,'frequency_text','2 Days / Week (Weekends)');
INSERT INTO `wp_postmeta` VALUES (1790,59,'_frequency_text','');
INSERT INTO `wp_postmeta` VALUES (1791,59,'eligibility_text','Children aged 5 to 12');
INSERT INTO `wp_postmeta` VALUES (1792,59,'_eligibility_text','');
INSERT INTO `wp_postmeta` VALUES (1793,60,'badge','Weekly Mentorship');
INSERT INTO `wp_postmeta` VALUES (1794,60,'_badge','field_a_badge');
INSERT INTO `wp_postmeta` VALUES (1795,60,'description','Character building, moral stories from Indian epics, civic duties, patriotic songs, shloka chanting, and cooperative traditional Indian sports.');
INSERT INTO `wp_postmeta` VALUES (1796,60,'_description','');
INSERT INTO `wp_postmeta` VALUES (1797,60,'centers_text','Available at 18+ Residential Neighborhood Centers');
INSERT INTO `wp_postmeta` VALUES (1798,60,'_centers_text','');
INSERT INTO `wp_postmeta` VALUES (1799,60,'_batches_text','');
INSERT INTO `wp_postmeta` VALUES (1800,60,'duration_text','2 Hours / Session | Continuous Character Mentorship');
INSERT INTO `wp_postmeta` VALUES (1801,60,'_duration_text','');
INSERT INTO `wp_postmeta` VALUES (1802,60,'frequency_text','Weekly (Every Sunday)');
INSERT INTO `wp_postmeta` VALUES (1803,60,'_frequency_text','');
INSERT INTO `wp_postmeta` VALUES (1804,60,'eligibility_text','Children aged 6 to 14');
INSERT INTO `wp_postmeta` VALUES (1805,60,'_eligibility_text','');
INSERT INTO `wp_postmeta` VALUES (1806,61,'badge','Teens & Youth');
INSERT INTO `wp_postmeta` VALUES (1807,61,'_badge','field_a_badge');
INSERT INTO `wp_postmeta` VALUES (1808,61,'description','Public speaking skills, emotional balance, critical thinking, leadership exercises, stage confidence, and interpersonal team workshops.');
INSERT INTO `wp_postmeta` VALUES (1809,61,'_description','');
INSERT INTO `wp_postmeta` VALUES (1810,61,'centers_text','Jayanagar, Malleswaram, Koramangala, Indiranagar, Basavanagudi');
INSERT INTO `wp_postmeta` VALUES (1811,61,'_centers_text','');
INSERT INTO `wp_postmeta` VALUES (1812,61,'_batches_text','');
INSERT INTO `wp_postmeta` VALUES (1813,61,'duration_text','8-Week Modular Workshop Series');
INSERT INTO `wp_postmeta` VALUES (1814,61,'_duration_text','');
INSERT INTO `wp_postmeta` VALUES (1815,61,'frequency_text','Weekly Sessions');
INSERT INTO `wp_postmeta` VALUES (1816,61,'_frequency_text','');
INSERT INTO `wp_postmeta` VALUES (1817,61,'eligibility_text','Teens & Youth aged 12 to 19');
INSERT INTO `wp_postmeta` VALUES (1818,61,'_eligibility_text','');
INSERT INTO `wp_postmeta` VALUES (1819,62,'badge','Holiday Camps');
INSERT INTO `wp_postmeta` VALUES (1820,62,'_badge','field_a_badge');
INSERT INTO `wp_postmeta` VALUES (1821,62,'description','Multi-activity vacation camps featuring arts, crafts, science experiments, yoga, Vedic mathematics, nature trails, and life skills.');
INSERT INTO `wp_postmeta` VALUES (1822,62,'_description','');
INSERT INTO `wp_postmeta` VALUES (1823,62,'centers_text','all 12 Centers across Bengaluru');
INSERT INTO `wp_postmeta` VALUES (1824,62,'_centers_text','');
INSERT INTO `wp_postmeta` VALUES (1825,62,'_batches_text','');
INSERT INTO `wp_postmeta` VALUES (1826,62,'duration_text','10 to 15 Days Immersive Vacation Camp');
INSERT INTO `wp_postmeta` VALUES (1827,62,'_duration_text','');
INSERT INTO `wp_postmeta` VALUES (1828,62,'frequency_text','Monday to Saturday during School Vacations');
INSERT INTO `wp_postmeta` VALUES (1829,62,'_frequency_text','');
INSERT INTO `wp_postmeta` VALUES (1830,62,'eligibility_text','Children aged 6 to 15');
INSERT INTO `wp_postmeta` VALUES (1831,62,'_eligibility_text','');
INSERT INTO `wp_postmeta` VALUES (1832,63,'badge','Coached Fitness');
INSERT INTO `wp_postmeta` VALUES (1833,63,'_badge','field_a_badge');
INSERT INTO `wp_postmeta` VALUES (1834,63,'description','Full-suite cardio, resistance, and functional training guided by certified trainers, with posture tracking and personal fitness roadmaps.');
INSERT INTO `wp_postmeta` VALUES (1835,63,'_description','');
INSERT INTO `wp_postmeta` VALUES (1836,63,'centers_text','Marathahalli, Sahakarnagar, Kengeri, Vijayanagar, Yelahanka');
INSERT INTO `wp_postmeta` VALUES (1837,63,'_centers_text','');
INSERT INTO `wp_postmeta` VALUES (1838,63,'_batches_text','');
INSERT INTO `wp_postmeta` VALUES (1839,63,'duration_text','Flexible Workout Slots (Monthly & Annual Plans)');
INSERT INTO `wp_postmeta` VALUES (1840,63,'_duration_text','');
INSERT INTO `wp_postmeta` VALUES (1841,63,'_frequency_text','');
INSERT INTO `wp_postmeta` VALUES (1842,63,'eligibility_text','Ages 16+ (Cardio & Resistance Guidance)');
INSERT INTO `wp_postmeta` VALUES (1843,63,'_eligibility_text','');
INSERT INTO `wp_postmeta` VALUES (1844,64,'badge','All Levels');
INSERT INTO `wp_postmeta` VALUES (1845,64,'_badge','field_a_badge');
INSERT INTO `wp_postmeta` VALUES (1846,64,'description','Hygienic, regulated swimming pools with certified coaching for beginners, stroke perfection for intermediate swimmers, and dedicated lap lanes.');
INSERT INTO `wp_postmeta` VALUES (1847,64,'_description','');
INSERT INTO `wp_postmeta` VALUES (1848,64,'centers_text','Marathahalli Sports Wing, Kengeri Campus');
INSERT INTO `wp_postmeta` VALUES (1849,64,'_centers_text','');
INSERT INTO `wp_postmeta` VALUES (1850,64,'_batches_text','');
INSERT INTO `wp_postmeta` VALUES (1851,64,'duration_text','45 Mins Coaching Slot | Monthly Batches');
INSERT INTO `wp_postmeta` VALUES (1852,64,'_duration_text','');
INSERT INTO `wp_postmeta` VALUES (1853,64,'frequency_text','6 Days / Week (Dedicated Ladies & Kids Batches)');
INSERT INTO `wp_postmeta` VALUES (1854,64,'_frequency_text','');
INSERT INTO `wp_postmeta` VALUES (1855,64,'eligibility_text','Ages 5+ to Adults');
INSERT INTO `wp_postmeta` VALUES (1856,64,'_eligibility_text','');
INSERT INTO `wp_postmeta` VALUES (1857,65,'badge','Indoor Sports');
INSERT INTO `wp_postmeta` VALUES (1858,65,'_badge','field_a_badge');
INSERT INTO `wp_postmeta` VALUES (1859,65,'description','Tournament-grade indoor tables, grip and spin technique coaching, match strategy, and intra-center ranking tournaments for amateur and competitive players.');
INSERT INTO `wp_postmeta` VALUES (1860,65,'_description','');
INSERT INTO `wp_postmeta` VALUES (1861,65,'centers_text','Malleswaram Complex, Marathahalli, Sahakarnagar, Jayanagar');
INSERT INTO `wp_postmeta` VALUES (1862,65,'_centers_text','');
INSERT INTO `wp_postmeta` VALUES (1863,65,'_batches_text','');
INSERT INTO `wp_postmeta` VALUES (1864,65,'duration_text','60 Mins Table Slot | Coaching Clinics Available');
INSERT INTO `wp_postmeta` VALUES (1865,65,'_duration_text','');
INSERT INTO `wp_postmeta` VALUES (1866,65,'frequency_text','Daily Slots & Weekend Leagues');
INSERT INTO `wp_postmeta` VALUES (1867,65,'_frequency_text','');
INSERT INTO `wp_postmeta` VALUES (1868,65,'eligibility_text','All Age Groups');
INSERT INTO `wp_postmeta` VALUES (1869,65,'_eligibility_text','');
INSERT INTO `wp_postmeta` VALUES (1870,66,'badge','Mind Sport');
INSERT INTO `wp_postmeta` VALUES (1871,66,'_badge','field_a_badge');
INSERT INTO `wp_postmeta` VALUES (1872,66,'description','Strategic opening theory, tactical puzzle solving, endgame calculation, and tournament readiness taught by FIDE rated coaches.');
INSERT INTO `wp_postmeta` VALUES (1873,66,'_description','');
INSERT INTO `wp_postmeta` VALUES (1874,66,'centers_text','Jayanagar, Malleswaram, Basavanagudi, Vijayanagar');
INSERT INTO `wp_postmeta` VALUES (1875,66,'_centers_text','');
INSERT INTO `wp_postmeta` VALUES (1876,66,'_batches_text','');
INSERT INTO `wp_postmeta` VALUES (1877,66,'duration_text','2 Hours / Class | Beginner to Advanced Syllabus');
INSERT INTO `wp_postmeta` VALUES (1878,66,'_duration_text','');
INSERT INTO `wp_postmeta` VALUES (1879,66,'frequency_text','2 Days / Week (Weekends)');
INSERT INTO `wp_postmeta` VALUES (1880,66,'_frequency_text','');
INSERT INTO `wp_postmeta` VALUES (1881,66,'eligibility_text','Ages 6+ to Adults');
INSERT INTO `wp_postmeta` VALUES (1882,66,'_eligibility_text','');
INSERT INTO `wp_postmeta` VALUES (1883,67,'badge','Confidential');
INSERT INTO `wp_postmeta` VALUES (1884,67,'_badge','field_a_badge');
INSERT INTO `wp_postmeta` VALUES (1885,67,'description','Confidential consultation, emotional stress alleviation, family counselling, and adolescent guidance guided by certified psychologists.');
INSERT INTO `wp_postmeta` VALUES (1886,67,'_description','');
INSERT INTO `wp_postmeta` VALUES (1887,67,'centers_text','Jayanagar, Malleswaram, Basavanagudi, Vijayanagar');
INSERT INTO `wp_postmeta` VALUES (1888,67,'_centers_text','');
INSERT INTO `wp_postmeta` VALUES (1889,67,'_batches_text','');
INSERT INTO `wp_postmeta` VALUES (1890,67,'duration_text','45 to 60 Mins per Confidential Session');
INSERT INTO `wp_postmeta` VALUES (1891,67,'_duration_text','');
INSERT INTO `wp_postmeta` VALUES (1892,67,'frequency_text','Weekly or Bi-weekly Follow-ups');
INSERT INTO `wp_postmeta` VALUES (1893,67,'_frequency_text','');
INSERT INTO `wp_postmeta` VALUES (1894,67,'eligibility_text','Individuals, Youth, Couples & Families');
INSERT INTO `wp_postmeta` VALUES (1895,67,'_eligibility_text','');
INSERT INTO `wp_postmeta` VALUES (1896,68,'badge','Natural Healing');
INSERT INTO `wp_postmeta` VALUES (1897,68,'_badge','field_a_badge');
INSERT INTO `wp_postmeta` VALUES (1898,68,'description','Non-invasive, meridian-based natural therapies promoting internal organ equilibrium, migraine relief, and digestive rejuvenation.');
INSERT INTO `wp_postmeta` VALUES (1899,68,'_description','');
INSERT INTO `wp_postmeta` VALUES (1900,68,'centers_text','Jayanagar, Basavanagudi, Malleswaram, Banashankari');
INSERT INTO `wp_postmeta` VALUES (1901,68,'_centers_text','');
INSERT INTO `wp_postmeta` VALUES (1902,68,'_batches_text','');
INSERT INTO `wp_postmeta` VALUES (1903,68,'duration_text','30 to 45 Mins / Treatment Session');
INSERT INTO `wp_postmeta` VALUES (1904,68,'_duration_text','');
INSERT INTO `wp_postmeta` VALUES (1905,68,'frequency_text','Course of 7 to 14 Therapy Sessions');
INSERT INTO `wp_postmeta` VALUES (1906,68,'_frequency_text','');
INSERT INTO `wp_postmeta` VALUES (1907,68,'eligibility_text','All ages seeking drugless holistic therapy');
INSERT INTO `wp_postmeta` VALUES (1908,68,'_eligibility_text','');
INSERT INTO `wp_postmeta` VALUES (1909,69,'badge','Clinical Care');
INSERT INTO `wp_postmeta` VALUES (1910,69,'_badge','field_a_badge');
INSERT INTO `wp_postmeta` VALUES (1911,69,'description','Integrated lifestyle disease reversal protocols, mud packs, hydrotherapy advice, diet counselling, and targeted therapeutic yogic cleansing (Shatkriyas).');
INSERT INTO `wp_postmeta` VALUES (1912,69,'_description','');
INSERT INTO `wp_postmeta` VALUES (1913,69,'centers_text','Jayanagar, Basavanagudi, Malleswaram, Banashankari, JP Nagar, Vijayanagar');
INSERT INTO `wp_postmeta` VALUES (1914,69,'_centers_text','');
INSERT INTO `wp_postmeta` VALUES (1915,69,'_batches_text','');
INSERT INTO `wp_postmeta` VALUES (1916,69,'duration_text','60 Mins / Consultation & Regimen');
INSERT INTO `wp_postmeta` VALUES (1917,69,'_duration_text','');
INSERT INTO `wp_postmeta` VALUES (1918,69,'_frequency_text','');
INSERT INTO `wp_postmeta` VALUES (1919,69,'eligibility_text','Patients with metabolic, spinal, or psychosomatic disorders');
INSERT INTO `wp_postmeta` VALUES (1920,69,'_eligibility_text','');
INSERT INTO `wp_postmeta` VALUES (1921,70,'badge','Restorative');
INSERT INTO `wp_postmeta` VALUES (1922,70,'_badge','field_a_badge');
INSERT INTO `wp_postmeta` VALUES (1923,70,'description','Traditional restorative herbal oil massages (Abhyanga) improving blood circulation, relieving chronic muscular fatigue, and promoting deep sleep.');
INSERT INTO `wp_postmeta` VALUES (1924,70,'_description','');
INSERT INTO `wp_postmeta` VALUES (1925,70,'centers_text','Jayanagar, Malleswaram, Basavanagudi Health Desks');
INSERT INTO `wp_postmeta` VALUES (1926,70,'_centers_text','');
INSERT INTO `wp_postmeta` VALUES (1927,70,'_batches_text','');
INSERT INTO `wp_postmeta` VALUES (1928,70,'duration_text','60 to 90 Mins / Authentic Abhyanga Session');
INSERT INTO `wp_postmeta` VALUES (1929,70,'_duration_text','');
INSERT INTO `wp_postmeta` VALUES (1930,70,'frequency_text','Weekly or Recommended Therapy Cycle');
INSERT INTO `wp_postmeta` VALUES (1931,70,'_frequency_text','');
INSERT INTO `wp_postmeta` VALUES (1932,70,'eligibility_text','Men & Women (Separate dedicated treatment suites)');
INSERT INTO `wp_postmeta` VALUES (1933,70,'_eligibility_text','');
INSERT INTO `wp_postmeta` VALUES (1934,71,'badge','Language');
INSERT INTO `wp_postmeta` VALUES (1935,71,'_badge','field_a_badge');
INSERT INTO `wp_postmeta` VALUES (1936,71,'description','Structured language learning from everyday conversational fluency to functional reading and classic Kannada literature appreciation.');
INSERT INTO `wp_postmeta` VALUES (1937,71,'_description','');
INSERT INTO `wp_postmeta` VALUES (1938,71,'centers_text','Indiranagar, Koramangala, Whitefield, Bellandur, HSR Layout, Malleswaram');
INSERT INTO `wp_postmeta` VALUES (1939,71,'_centers_text','');
INSERT INTO `wp_postmeta` VALUES (1940,71,'_batches_text','');
INSERT INTO `wp_postmeta` VALUES (1941,71,'duration_text','3-Month Conversational & Reading Certification');
INSERT INTO `wp_postmeta` VALUES (1942,71,'_duration_text','');
INSERT INTO `wp_postmeta` VALUES (1943,71,'frequency_text','2 Days / Week');
INSERT INTO `wp_postmeta` VALUES (1944,71,'_frequency_text','');
INSERT INTO `wp_postmeta` VALUES (1945,71,'eligibility_text','Non-Kannada speakers, New Residents & Professionals');
INSERT INTO `wp_postmeta` VALUES (1946,71,'_eligibility_text','');
INSERT INTO `wp_postmeta` VALUES (1947,72,'badge','Civilizational Heritage');
INSERT INTO `wp_postmeta` VALUES (1948,72,'_badge','field_a_badge');
INSERT INTO `wp_postmeta` VALUES (1949,72,'description','Inspiring discourses on Indian civilizational history, ethics, universal dharma, and global contributions of ancient Indian wisdom.');
INSERT INTO `wp_postmeta` VALUES (1950,72,'_description','');
INSERT INTO `wp_postmeta` VALUES (1951,72,'centers_text','Basavanagudi, Malleswaram, Jayanagar, Rajajinagar');
INSERT INTO `wp_postmeta` VALUES (1952,72,'_centers_text','');
INSERT INTO `wp_postmeta` VALUES (1953,72,'_batches_text','');
INSERT INTO `wp_postmeta` VALUES (1954,72,'duration_text','90 Mins Lecture & Interactive Discussion');
INSERT INTO `wp_postmeta` VALUES (1955,72,'_duration_text','');
INSERT INTO `wp_postmeta` VALUES (1956,72,'frequency_text','Weekly Sessions');
INSERT INTO `wp_postmeta` VALUES (1957,72,'_frequency_text','');
INSERT INTO `wp_postmeta` VALUES (1958,72,'eligibility_text','Youth, Scholars & Cultural Seekers');
INSERT INTO `wp_postmeta` VALUES (1959,72,'_eligibility_text','');
INSERT INTO `wp_postmeta` VALUES (1960,73,'badge','Wisdom Circle');
INSERT INTO `wp_postmeta` VALUES (1961,73,'_badge','field_a_badge');
INSERT INTO `wp_postmeta` VALUES (1962,73,'description','Verse-by-verse chanting, Sanskrit grammatical meaning, philosophical inquiry, and practical life applications for peaceful, purposeful modern living.');
INSERT INTO `wp_postmeta` VALUES (1963,73,'_description','');
INSERT INTO `wp_postmeta` VALUES (1964,73,'centers_text','Jayanagar, Basavanagudi, Malleswaram, Vijayanagar, Padmanabhanagar, Banashankari');
INSERT INTO `wp_postmeta` VALUES (1965,73,'_centers_text','');
INSERT INTO `wp_postmeta` VALUES (1966,73,'_batches_text','');
INSERT INTO `wp_postmeta` VALUES (1967,73,'duration_text','75 Mins / Session | Continuous Chapter-by-Chapter Study');
INSERT INTO `wp_postmeta` VALUES (1968,73,'_duration_text','');
INSERT INTO `wp_postmeta` VALUES (1969,73,'frequency_text','Weekly Sessions');
INSERT INTO `wp_postmeta` VALUES (1970,73,'_frequency_text','');
INSERT INTO `wp_postmeta` VALUES (1971,73,'eligibility_text','Open to All Seekers');
INSERT INTO `wp_postmeta` VALUES (1972,73,'_eligibility_text','');
INSERT INTO `wp_postmeta` VALUES (1973,74,'badge','Artistry');
INSERT INTO `wp_postmeta` VALUES (1974,74,'_badge','field_a_badge');
INSERT INTO `wp_postmeta` VALUES (1975,74,'description','Mindful handwritten script artistry, Devanagari lettering, sacred Yantra geometry, and traditional Indian motif illustrations.');
INSERT INTO `wp_postmeta` VALUES (1976,74,'_description','');
INSERT INTO `wp_postmeta` VALUES (1977,74,'centers_text','Malleswaram, Basavanagudi, Jayanagar');
INSERT INTO `wp_postmeta` VALUES (1978,74,'_centers_text','');
INSERT INTO `wp_postmeta` VALUES (1979,74,'_batches_text','');
INSERT INTO `wp_postmeta` VALUES (1980,74,'duration_text','2 Hours / Workshop | 8-Week Masterclass');
INSERT INTO `wp_postmeta` VALUES (1981,74,'_duration_text','');
INSERT INTO `wp_postmeta` VALUES (1982,74,'frequency_text','Weekly Sessions');
INSERT INTO `wp_postmeta` VALUES (1983,74,'_frequency_text','');
INSERT INTO `wp_postmeta` VALUES (1984,74,'eligibility_text','Ages 10+ to Adults');
INSERT INTO `wp_postmeta` VALUES (1985,74,'_eligibility_text','');
INSERT INTO `wp_postmeta` VALUES (2332,167,'phone',7899423350);
INSERT INTO `wp_postmeta` VALUES (2333,167,'area','Sadashivnagar');
INSERT INTO `wp_postmeta` VALUES (2334,167,'_ry_image_url','http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/dsc08484.jpg');
INSERT INTO `wp_postmeta` VALUES (2335,167,'programs',11);
INSERT INTO `wp_postmeta` VALUES (2336,167,'programs_0_program_name','Yoga Beginners');
INSERT INTO `wp_postmeta` VALUES (2337,167,'programs_0_timings','05:45am,   07:00 am,  11:00 am,   04:45 pm,   06:30 pm.');
INSERT INTO `wp_postmeta` VALUES (2338,167,'programs_1_program_name','Yoga Inter-Mediate');
INSERT INTO `wp_postmeta` VALUES (2339,167,'programs_1_timings','05:50am,   07:15 am,   08:30 am,   05:00 pm,   06:30 pm');
INSERT INTO `wp_postmeta` VALUES (2340,167,'programs_2_program_name','Yoga Senior');
INSERT INTO `wp_postmeta` VALUES (2341,167,'programs_2_timings','05:40 am,   05:45am,   06:55 am,   07:00 am,   11:00 am,   04:45 pm,  06:30 pm');
INSERT INTO `wp_postmeta` VALUES (2342,167,'programs_3_program_name','Yoga Therapy');
INSERT INTO `wp_postmeta` VALUES (2343,167,'programs_3_timings','05:45 am,   07:00 am,   11:00 am,   04:30 pm,   06:30 pm');
INSERT INTO `wp_postmeta` VALUES (2344,167,'programs_4_program_name','Yoga Weekend');
INSERT INTO `wp_postmeta` VALUES (2345,167,'programs_4_timings','Sat & Sun 06:30 am to 07:40 am');
INSERT INTO `wp_postmeta` VALUES (2346,167,'programs_5_program_name','Yoga Children');
INSERT INTO `wp_postmeta` VALUES (2347,167,'programs_5_timings','Sun 07:30 am to 08:30 am');
INSERT INTO `wp_postmeta` VALUES (2348,167,'programs_6_program_name','Keyboard');
INSERT INTO `wp_postmeta` VALUES (2349,167,'programs_6_timings','Tues & Thrs 06:00 PM  07:00 pm');
INSERT INTO `wp_postmeta` VALUES (2350,167,'programs_7_program_name','Bharatanatyam');
INSERT INTO `wp_postmeta` VALUES (2351,167,'programs_7_timings','Mon & Fri 5:00:00 pm to 06:30 pm');
INSERT INTO `wp_postmeta` VALUES (2352,167,'programs_8_program_name','Taekwondo');
INSERT INTO `wp_postmeta` VALUES (2353,167,'programs_8_timings','Tues & Thurs 05:00 pm 06:00 pm');
INSERT INTO `wp_postmeta` VALUES (2354,167,'programs_9_program_name','Bala Samskara Kendra');
INSERT INTO `wp_postmeta` VALUES (2355,167,'programs_9_timings','Sat 04:00 pm 05:00 pm');
INSERT INTO `wp_postmeta` VALUES (2356,167,'programs_10_program_name','Bhagavad Gita Class');
INSERT INTO `wp_postmeta` VALUES (2357,167,'programs_10_timings','Wed 06:00 pm 07:00 pm');
INSERT INTO `wp_postmeta` VALUES (2358,168,'phone',9632518598);
INSERT INTO `wp_postmeta` VALUES (2359,168,'area','Gayathrinagar');
INSERT INTO `wp_postmeta` VALUES (2360,168,'_ry_image_url','http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/08-02-22-rathasaptami-celebration-yoga-centres-bengaluru-6-.jpg');
INSERT INTO `wp_postmeta` VALUES (2361,168,'programs',0);
INSERT INTO `wp_postmeta` VALUES (2362,169,'phone',8123523952);
INSERT INTO `wp_postmeta` VALUES (2363,169,'area','RBI Layout');
INSERT INTO `wp_postmeta` VALUES (2364,169,'_ry_image_url','http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/dsc08572.jpg');
INSERT INTO `wp_postmeta` VALUES (2365,169,'programs',6);
INSERT INTO `wp_postmeta` VALUES (2366,169,'programs_0_program_name','karate  5:30pm');
INSERT INTO `wp_postmeta` VALUES (2367,169,'programs_0_timings','');
INSERT INTO `wp_postmeta` VALUES (2368,169,'programs_1_program_name','tabala 5:30');
INSERT INTO `wp_postmeta` VALUES (2369,169,'programs_1_timings','');
INSERT INTO `wp_postmeta` VALUES (2370,169,'programs_2_program_name','keybord  5:30');
INSERT INTO `wp_postmeta` VALUES (2371,169,'programs_2_timings','');
INSERT INTO `wp_postmeta` VALUES (2372,169,'programs_3_program_name','flute  5:40');
INSERT INTO `wp_postmeta` VALUES (2373,169,'programs_3_timings','');
INSERT INTO `wp_postmeta` VALUES (2374,169,'programs_4_program_name','bharatanatyam 5:40');
INSERT INTO `wp_postmeta` VALUES (2375,169,'programs_4_timings','');
INSERT INTO `wp_postmeta` VALUES (2376,169,'programs_5_program_name','carnatic music 5:00pm');
INSERT INTO `wp_postmeta` VALUES (2377,169,'programs_5_timings','');
INSERT INTO `wp_postmeta` VALUES (2378,170,'phone',9663409607);
INSERT INTO `wp_postmeta` VALUES (2379,170,'area','KAMAKSHIPALYA');
INSERT INTO `wp_postmeta` VALUES (2380,170,'_ry_image_url','http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/01-02-25-aaraadhana-mahotsava-in-rysri-jayanagar-4-.jpg');
INSERT INTO `wp_postmeta` VALUES (2381,170,'programs',0);
INSERT INTO `wp_postmeta` VALUES (2382,171,'phone',9482834425);
INSERT INTO `wp_postmeta` VALUES (2383,171,'area','KG NAGAR');
INSERT INTO `wp_postmeta` VALUES (2384,171,'_ry_image_url','http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1-.jpg');
INSERT INTO `wp_postmeta` VALUES (2385,171,'programs',1);
INSERT INTO `wp_postmeta` VALUES (2386,171,'programs_0_program_name','Junior \n5:45 AM - 10:30 AM , 4:30 & 6:30 PM\n\nSenior \n5:45 AM , 7:00 AM - 10:30 AM , 4:30 & 6:30 PM\n\nTHERAPY \n5:30 AM , 7:00 AM - 10:30 AM , 4:30 & 6:30 PM\n\nGERENAL \n5:45 AM , 7:00 AM, 7:30 AM  - 10:30 AM , 4:30 & 6:30 PM\n\nCHILDREN \n7:30  AM');
INSERT INTO `wp_postmeta` VALUES (2387,171,'programs_0_timings','');
INSERT INTO `wp_postmeta` VALUES (2388,172,'phone',9481240776);
INSERT INTO `wp_postmeta` VALUES (2389,172,'area','Nagarbhavi');
INSERT INTO `wp_postmeta` VALUES (2390,172,'_ry_image_url','http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/21-06-24-idy-celebration-in-rysri-yoga-centres-5-.jpeg');
INSERT INTO `wp_postmeta` VALUES (2391,172,'programs',1);
INSERT INTO `wp_postmeta` VALUES (2392,172,'programs_0_program_name','Bala Samskara Kendra 4:00pm');
INSERT INTO `wp_postmeta` VALUES (2393,172,'programs_0_timings','');
INSERT INTO `wp_postmeta` VALUES (2394,173,'phone',6360926332);
INSERT INTO `wp_postmeta` VALUES (2395,173,'area','Vijaynagar');
INSERT INTO `wp_postmeta` VALUES (2396,173,'_ry_image_url','http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/rysri-sadashivanagar.jpg');
INSERT INTO `wp_postmeta` VALUES (2397,173,'programs',1);
INSERT INTO `wp_postmeta` VALUES (2398,173,'programs_0_program_name','Carnatic Sangeeta 5.00PM Bharatanatyam 5.30PM Tabala 5.00PM Key Board 5.30PM Teakwondo 5.30 PM Samskrita Bala Kendra 4.30PM  Counseling 5.00PM');
INSERT INTO `wp_postmeta` VALUES (2399,173,'programs_0_timings','Y Beginner 5.50AM');
INSERT INTO `wp_postmeta` VALUES (2400,174,'phone','9148926940, 6362250617');
INSERT INTO `wp_postmeta` VALUES (2401,174,'area','Sunkenahalli');
INSERT INTO `wp_postmeta` VALUES (2402,174,'_ry_image_url','http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/rysri-kundalahalli-2-.jpg');
INSERT INTO `wp_postmeta` VALUES (2403,174,'programs',28);
INSERT INTO `wp_postmeta` VALUES (2404,174,'programs_0_program_name','Junior');
INSERT INTO `wp_postmeta` VALUES (2405,174,'programs_0_timings','5:00 AM\n 6:10 AM\n 7:20 AM\n 11:00 AM\n 5:00 PM');
INSERT INTO `wp_postmeta` VALUES (2406,174,'programs_1_program_name','Light Music');
INSERT INTO `wp_postmeta` VALUES (2407,174,'programs_1_timings','Thursday\n 5:30 PM to 7:00 PM');
INSERT INTO `wp_postmeta` VALUES (2408,174,'programs_2_program_name','Karate (W/D)');
INSERT INTO `wp_postmeta` VALUES (2409,174,'programs_2_timings','Tuesday & Thursday\n 5:15 PM to 6:15 PM');
INSERT INTO `wp_postmeta` VALUES (2410,174,'programs_3_program_name','Acupressure');
INSERT INTO `wp_postmeta` VALUES (2411,174,'programs_3_timings','Monday, Wednesday, Friday\n 5:30 PM to 7:30 PM');
INSERT INTO `wp_postmeta` VALUES (2412,174,'programs_4_program_name','General');
INSERT INTO `wp_postmeta` VALUES (2413,174,'programs_4_timings','5:00 AM\n 6:10 AM\n 7:20 AM\n 8:30 AM\n 11:00 AM\n 4:30 PM\n 6:00 PM\n 6:45 PM');
INSERT INTO `wp_postmeta` VALUES (2414,174,'programs_5_program_name','Carnatic Sangeetha');
INSERT INTO `wp_postmeta` VALUES (2415,174,'programs_5_timings','Wednesday & Friday\n 5:00 PM to 6:30 PM');
INSERT INTO `wp_postmeta` VALUES (2416,174,'programs_6_program_name','Karate (W/E)');
INSERT INTO `wp_postmeta` VALUES (2417,174,'programs_6_timings','Saturday 4:30 PM to 5:30 PM\n Sunday 8:30 AM to 9:30 AM');
INSERT INTO `wp_postmeta` VALUES (2418,174,'programs_7_program_name','Colour Therapy');
INSERT INTO `wp_postmeta` VALUES (2419,174,'programs_7_timings','Monday to Saturday\n 10:00 AM to 4:30 PM\n Sunday \n 10:00 AM to 01:00 PM');
INSERT INTO `wp_postmeta` VALUES (2420,174,'programs_8_program_name','Senior');
INSERT INTO `wp_postmeta` VALUES (2421,174,'programs_8_timings','5:00 AM\n 6:00 AM\n 6:10 AM\n 7:20 AM\n 11:00 AM\n 5:00 PM\n 6:30 PM');
INSERT INTO `wp_postmeta` VALUES (2422,174,'programs_9_program_name','Hindusthani Sangeetha');
INSERT INTO `wp_postmeta` VALUES (2423,174,'programs_9_timings','Monday & Thursday\n  5:30 PM to 7:00 PM');
INSERT INTO `wp_postmeta` VALUES (2424,174,'programs_10_program_name','Chess (W/D)');
INSERT INTO `wp_postmeta` VALUES (2425,174,'programs_10_timings','Tuesday & Thursday\n 6:30 PM to 7:45 PM');
INSERT INTO `wp_postmeta` VALUES (2426,174,'programs_11_program_name','Counselling');
INSERT INTO `wp_postmeta` VALUES (2427,174,'programs_11_timings','Tuesday & Saturday\n 03:00 PM to 6:00 PM');
INSERT INTO `wp_postmeta` VALUES (2428,174,'programs_12_program_name','Therapy');
INSERT INTO `wp_postmeta` VALUES (2429,174,'programs_12_timings','6:00 AM\n 7:20 AM\n 11:00 AM\n 4:00 PM\n 5:00 PM\n 6:30 PM');
INSERT INTO `wp_postmeta` VALUES (2430,174,'programs_13_program_name','Flute');
INSERT INTO `wp_postmeta` VALUES (2431,174,'programs_13_timings','Tuesday 5:00 PM to 6:30 PM\n Sunday 9:30 AM to 10:45 AM');
INSERT INTO `wp_postmeta` VALUES (2432,174,'programs_14_program_name','Chess (W/E)');
INSERT INTO `wp_postmeta` VALUES (2433,174,'programs_14_timings','Saturday 5:00 PM to 7:00 PM\n Sunday 11:00 AM to 01:00 PM');
INSERT INTO `wp_postmeta` VALUES (2434,174,'programs_15_program_name','Childrens Yoga Batch (W/D)');
INSERT INTO `wp_postmeta` VALUES (2435,174,'programs_15_timings','4:30 PM');
INSERT INTO `wp_postmeta` VALUES (2436,174,'programs_16_program_name','Violin');
INSERT INTO `wp_postmeta` VALUES (2437,174,'programs_16_timings','Tuesday & Thursday\n 5:15 PM to 6:45 PM');
INSERT INTO `wp_postmeta` VALUES (2438,174,'programs_17_program_name','Art Class');
INSERT INTO `wp_postmeta` VALUES (2439,174,'programs_17_timings','Wednesday \n 5:15 PM to 6:45PM');
INSERT INTO `wp_postmeta` VALUES (2440,174,'programs_18_program_name','Childrens Yoga Batch (W/E)');
INSERT INTO `wp_postmeta` VALUES (2441,174,'programs_18_timings','7:00 AM');
INSERT INTO `wp_postmeta` VALUES (2442,174,'programs_19_program_name','Key Board');
INSERT INTO `wp_postmeta` VALUES (2443,174,'programs_19_timings','Monday & Wednesday\n 5:00 PM to 6:00 PM\n 6:00 PM to 7:00 PM');
INSERT INTO `wp_postmeta` VALUES (2444,174,'programs_20_program_name','Calligraphy');
INSERT INTO `wp_postmeta` VALUES (2445,174,'programs_20_timings','Friday\n 5:15 PM to 6:45 PM');
INSERT INTO `wp_postmeta` VALUES (2446,174,'programs_21_program_name','Weekend Batch');
INSERT INTO `wp_postmeta` VALUES (2447,174,'programs_21_timings','6:00 AM (Saturday)\n 7:20 AM (Saturday)\n 7:00 AM (Sunday)');
INSERT INTO `wp_postmeta` VALUES (2448,174,'programs_22_program_name','Tabala');
INSERT INTO `wp_postmeta` VALUES (2449,174,'programs_22_timings','Tuesday & Friday\n 5:00 PM to 6:30 PM');
INSERT INTO `wp_postmeta` VALUES (2450,174,'programs_23_program_name','Bhagavadgeetha (W/D)');
INSERT INTO `wp_postmeta` VALUES (2451,174,'programs_23_timings','Thursday\n 5:15 PM to 6:45 PM');
INSERT INTO `wp_postmeta` VALUES (2452,174,'programs_24_program_name','Mrudanga');
INSERT INTO `wp_postmeta` VALUES (2453,174,'programs_24_timings','Saturday 4:00 PM to 5:00 PM\n Sunday 9:00 AM to 10:00 AM');
INSERT INTO `wp_postmeta` VALUES (2454,174,'programs_25_program_name','Bhagavadgeetha (W/E) Free');
INSERT INTO `wp_postmeta` VALUES (2455,174,'programs_25_timings','Saturday 6:00 PM to 7:30 PM');
INSERT INTO `wp_postmeta` VALUES (2456,174,'programs_26_program_name','Veena');
INSERT INTO `wp_postmeta` VALUES (2457,174,'programs_26_timings','Tuesday & Saturday\n 5:00 PM to 6:30 PM');
INSERT INTO `wp_postmeta` VALUES (2458,174,'programs_27_program_name','Bala Samskara Kendra');
INSERT INTO `wp_postmeta` VALUES (2459,174,'programs_27_timings','Sunday 10:00 AM to 01:00 PM');
INSERT INTO `wp_postmeta` VALUES (2460,175,'phone',9353095860);
INSERT INTO `wp_postmeta` VALUES (2461,175,'area','Girinagar');
INSERT INTO `wp_postmeta` VALUES (2462,175,'_ry_image_url','http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/rysri-kundalahalli-2-.jpg');
INSERT INTO `wp_postmeta` VALUES (2463,175,'programs',3);
INSERT INTO `wp_postmeta` VALUES (2464,175,'programs_0_program_name','Gerenal \n7:00 AM\n10:30 AM');
INSERT INTO `wp_postmeta` VALUES (2465,175,'programs_0_timings','');
INSERT INTO `wp_postmeta` VALUES (2466,175,'programs_1_program_name','Kathak');
INSERT INTO `wp_postmeta` VALUES (2467,175,'programs_1_timings','Saturday 5:00 PM to 6:00 PM\n Sunday 9:30 AM to 10:30 AM');
INSERT INTO `wp_postmeta` VALUES (2468,175,'programs_2_program_name','Rangoli');
INSERT INTO `wp_postmeta` VALUES (2469,175,'programs_2_timings','Monday 5:00 PM to 6:30 PM');
INSERT INTO `wp_postmeta` VALUES (2470,176,'phone',9353095860);
INSERT INTO `wp_postmeta` VALUES (2471,176,'area','Aksharam');
INSERT INTO `wp_postmeta` VALUES (2472,176,'_ry_image_url','http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1-.jpg');
INSERT INTO `wp_postmeta` VALUES (2473,176,'programs',3);
INSERT INTO `wp_postmeta` VALUES (2474,176,'programs_0_program_name','Gerenal \n6:00 AM');
INSERT INTO `wp_postmeta` VALUES (2475,176,'programs_0_timings','');
INSERT INTO `wp_postmeta` VALUES (2476,176,'programs_1_program_name','Bharathanatyam (W/E)');
INSERT INTO `wp_postmeta` VALUES (2477,176,'programs_1_timings','Saturday 5:00 PM to 7:00 PM\n Sunday 9:30 AM to 11:30 AM');
INSERT INTO `wp_postmeta` VALUES (2478,176,'programs_2_program_name','Bharathanatyam (W/D)');
INSERT INTO `wp_postmeta` VALUES (2479,176,'programs_2_timings','Monday & Wednesday\n 5:00 PM to 6:30 PM');
INSERT INTO `wp_postmeta` VALUES (2480,177,'phone','7975344715 / 6366244019');
INSERT INTO `wp_postmeta` VALUES (2481,177,'area','Kundalahalli');
INSERT INTO `wp_postmeta` VALUES (2482,177,'_ry_image_url','http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/21-06-24-idy-celebration-in-rysri-yoga-centres-5-.jpeg');
INSERT INTO `wp_postmeta` VALUES (2483,177,'programs',57);
INSERT INTO `wp_postmeta` VALUES (2484,177,'programs_0_program_name','Beginner');
INSERT INTO `wp_postmeta` VALUES (2485,177,'programs_0_timings','5:45 AM, 7:00 AM,11:00 AM, 5:00 PM, 6:30 PM');
INSERT INTO `wp_postmeta` VALUES (2486,177,'programs_1_program_name','Bharatanatyam WD');
INSERT INTO `wp_postmeta` VALUES (2487,177,'programs_1_timings','Tuesday & Friday -                            5:00 PM to 7:00 PM');
INSERT INTO `wp_postmeta` VALUES (2488,177,'programs_2_program_name','Art');
INSERT INTO `wp_postmeta` VALUES (2489,177,'programs_2_timings','Thursday - 4:30 PM to 5:45 PM   Saturday - 5:00 PM to 6:15 PM');
INSERT INTO `wp_postmeta` VALUES (2490,177,'programs_3_program_name','Ayurveda Consultation & Yoga Wellness');
INSERT INTO `wp_postmeta` VALUES (2491,177,'programs_3_timings','Tuesday & Saturday -                      5:30 PM to 7:00 PM');
INSERT INTO `wp_postmeta` VALUES (2492,177,'programs_4_program_name','Aquatic (Swimming)');
INSERT INTO `wp_postmeta` VALUES (2493,177,'programs_4_timings','');
INSERT INTO `wp_postmeta` VALUES (2494,177,'programs_5_program_name','Table Tennis');
INSERT INTO `wp_postmeta` VALUES (2495,177,'programs_5_timings','');
INSERT INTO `wp_postmeta` VALUES (2496,177,'programs_6_program_name','Intermediate');
INSERT INTO `wp_postmeta` VALUES (2497,177,'programs_6_timings','6:15 AM, 7:00 AM, 7:30 AM');
INSERT INTO `wp_postmeta` VALUES (2498,177,'programs_7_program_name','Bharatanatyam WE');
INSERT INTO `wp_postmeta` VALUES (2499,177,'programs_7_timings','Saturday  - 4:00 PM to 6:00 PM     Sunday - 9:30 AM to 11:30 AM');
INSERT INTO `wp_postmeta` VALUES (2500,177,'programs_8_program_name','Karate WD');
INSERT INTO `wp_postmeta` VALUES (2501,177,'programs_8_timings','Monday & Wednesday  -                      5:30 PM to 7:00 PM');
INSERT INTO `wp_postmeta` VALUES (2502,177,'programs_9_program_name','Acupuncture Therapy');
INSERT INTO `wp_postmeta` VALUES (2503,177,'programs_9_timings','Tuesday & Friday -                      6:00 PM to 7:00 PM');
INSERT INTO `wp_postmeta` VALUES (2504,177,'programs_10_program_name','Personal Training');
INSERT INTO `wp_postmeta` VALUES (2505,177,'programs_10_timings','4 / 8 Session');
INSERT INTO `wp_postmeta` VALUES (2506,177,'programs_11_program_name','Personal Training');
INSERT INTO `wp_postmeta` VALUES (2507,177,'programs_11_timings','8 Session');
INSERT INTO `wp_postmeta` VALUES (2508,177,'programs_12_program_name','Senior');
INSERT INTO `wp_postmeta` VALUES (2509,177,'programs_12_timings','5:45 AM, 7:00 AM,11:00 AM, 5:00 PM, 6:30 PM');
INSERT INTO `wp_postmeta` VALUES (2510,177,'programs_13_program_name','Carnatic Music');
INSERT INTO `wp_postmeta` VALUES (2511,177,'programs_13_timings','Tuesday & Thursday -                      5:30 PM to 7:00 PM');
INSERT INTO `wp_postmeta` VALUES (2512,177,'programs_14_program_name','Karate WE');
INSERT INTO `wp_postmeta` VALUES (2513,177,'programs_14_timings','Saturday - 5:00 PM to 6:15 PM  Sunday - 8:00 AM to 9:15 AM');
INSERT INTO `wp_postmeta` VALUES (2514,177,'programs_15_program_name','Counselling Center / Acupressure / Colour Therapy / Home Remedies');
INSERT INTO `wp_postmeta` VALUES (2515,177,'programs_15_timings','Wednesday & Thursday -         4:30 PM to 6:15 PM,             Friday - 4:30 PM to 6:00 PM,   Saturday - 4:30 PM to 6:15 PM');
INSERT INTO `wp_postmeta` VALUES (2516,177,'programs_16_program_name','Coaching - Toddlers (<3.5 Yrs)');
INSERT INTO `wp_postmeta` VALUES (2517,177,'programs_16_timings','(8 Session) - Saturday & Sunday');
INSERT INTO `wp_postmeta` VALUES (2518,177,'programs_17_program_name','Kids Coaching (6-15) yrs');
INSERT INTO `wp_postmeta` VALUES (2519,177,'programs_17_timings','');
INSERT INTO `wp_postmeta` VALUES (2520,177,'programs_18_program_name','General');
INSERT INTO `wp_postmeta` VALUES (2521,177,'programs_18_timings','5:45 AM, 6:30 AM, 8:20 AM,11:00 AM, 4:30 PM, 6:45 PM');
INSERT INTO `wp_postmeta` VALUES (2522,177,'programs_19_program_name','Kathak');
INSERT INTO `wp_postmeta` VALUES (2523,177,'programs_19_timings','Wednesday - 5:30 PM to 7:00 PM     Sunday - 9:30 AM to 11:00 AM');
INSERT INTO `wp_postmeta` VALUES (2524,177,'programs_20_program_name','Kalaripayattu');
INSERT INTO `wp_postmeta` VALUES (2525,177,'programs_20_timings','Thursday & Saturday -             5:30 PM to 7:00 PM');
INSERT INTO `wp_postmeta` VALUES (2526,177,'programs_21_program_name','Coaching - Kids              (4 - 6 Yrs)');
INSERT INTO `wp_postmeta` VALUES (2527,177,'programs_21_timings','(16 Session) - Tuesday to Friday  (8 Session) - Saturday & Sunday');
INSERT INTO `wp_postmeta` VALUES (2528,177,'programs_22_program_name','2 Days / Weekly (8 Session)');
INSERT INTO `wp_postmeta` VALUES (2529,177,'programs_22_timings','(Saturday & Sunday)  8:00 AM to 9:00 AM');
INSERT INTO `wp_postmeta` VALUES (2530,177,'programs_23_program_name','Therapy');
INSERT INTO `wp_postmeta` VALUES (2531,177,'programs_23_timings','7:00 AM,11:00 AM, 4:30 PM');
INSERT INTO `wp_postmeta` VALUES (2532,177,'programs_24_program_name','Hindusthani Music');
INSERT INTO `wp_postmeta` VALUES (2533,177,'programs_24_timings','Tuesday & Friday -                            6:00 PM to 7:30 PM');
INSERT INTO `wp_postmeta` VALUES (2534,177,'programs_25_program_name','Chess');
INSERT INTO `wp_postmeta` VALUES (2535,177,'programs_25_timings','Wednesday & Saturday -             5:30 PM to 7:00 PM');
INSERT INTO `wp_postmeta` VALUES (2536,177,'programs_26_program_name','Kannda Spoken Classes');
INSERT INTO `wp_postmeta` VALUES (2537,177,'programs_26_timings','Monday & Wednesday  -                      6:15 PM to 7:45 PM');
INSERT INTO `wp_postmeta` VALUES (2538,177,'programs_27_program_name','Coaching - Kids            (7 - 15 Yrs)');
INSERT INTO `wp_postmeta` VALUES (2539,177,'programs_27_timings','(16 Session) - Tuesday to Friday  (8 Session) - Saturday & Sunday');
INSERT INTO `wp_postmeta` VALUES (2540,177,'programs_28_program_name','3 Days / Weekly (12 Session),      4 Days / Weekly (16 Session)');
INSERT INTO `wp_postmeta` VALUES (2541,177,'programs_28_timings','(Tuesday to Friday)            5:00 PM to 6:00 PM (B), 5:45 PM to 7:00 PM (I)');
INSERT INTO `wp_postmeta` VALUES (2542,177,'programs_29_program_name','Prenatal Yoga');
INSERT INTO `wp_postmeta` VALUES (2543,177,'programs_29_timings','6:15 PM');
INSERT INTO `wp_postmeta` VALUES (2544,177,'programs_30_program_name','Tabala');
INSERT INTO `wp_postmeta` VALUES (2545,177,'programs_30_timings','Monday & Saturday -                      5:30 PM to 6:45 PM');
INSERT INTO `wp_postmeta` VALUES (2546,177,'programs_31_program_name','Bala Samskara Kendra');
INSERT INTO `wp_postmeta` VALUES (2547,177,'programs_31_timings','Saturday - 4:00 PM to 5:30 PM');
INSERT INTO `wp_postmeta` VALUES (2548,177,'programs_32_program_name','Book Store');
INSERT INTO `wp_postmeta` VALUES (2549,177,'programs_32_timings','Monday to Friday  -                      4:30 PM to 7:30 PM');
INSERT INTO `wp_postmeta` VALUES (2550,177,'programs_33_program_name','Coaching - Adults');
INSERT INTO `wp_postmeta` VALUES (2551,177,'programs_33_timings','(16 Session) - Tuesday to Friday  (8 Session) - Saturday & Sunday');
INSERT INTO `wp_postmeta` VALUES (2552,177,'programs_34_program_name','Adults Coaching');
INSERT INTO `wp_postmeta` VALUES (2553,177,'programs_34_timings','');
INSERT INTO `wp_postmeta` VALUES (2554,177,'programs_35_program_name','Weekend Yoga (YB / YS)');
INSERT INTO `wp_postmeta` VALUES (2555,177,'programs_35_timings','6:30 AM');
INSERT INTO `wp_postmeta` VALUES (2556,177,'programs_36_program_name','Veena');
INSERT INTO `wp_postmeta` VALUES (2557,177,'programs_36_timings','Monday & Thursday  -                      5:30 PM to 7:00 PM');
INSERT INTO `wp_postmeta` VALUES (2558,177,'programs_37_program_name','Vishnusahasranama');
INSERT INTO `wp_postmeta` VALUES (2559,177,'programs_37_timings','Saturday - 5:00 PM to 6:00 PM');
INSERT INTO `wp_postmeta` VALUES (2560,177,'programs_38_program_name','Sanskrita Sambashana Shibira');
INSERT INTO `wp_postmeta` VALUES (2561,177,'programs_38_timings','Sunday - 9:30 AM to 11:00 AM');
INSERT INTO `wp_postmeta` VALUES (2562,177,'programs_39_program_name','Swim Membership                        (Lap Swim hour)');
INSERT INTO `wp_postmeta` VALUES (2563,177,'programs_39_timings','(16 Session) - Tuesday to Friday  (8 Session) - Saturday & Sunday (24 Session) - Tuesday to Sunday');
INSERT INTO `wp_postmeta` VALUES (2564,177,'programs_40_program_name','3 Days / Weekly (12 Session),      4 Days / Weekly (16 Session)');
INSERT INTO `wp_postmeta` VALUES (2565,177,'programs_40_timings','(Tuesday to Friday)        7:00 AM to 8:00 AM,       8:00 AM to 9:00 AM,        7:00 PM to 8:00 PM');
INSERT INTO `wp_postmeta` VALUES (2566,177,'programs_41_program_name','Children Yoga WD');
INSERT INTO `wp_postmeta` VALUES (2567,177,'programs_41_timings','5:00 PM');
INSERT INTO `wp_postmeta` VALUES (2568,177,'programs_42_program_name','Key Board');
INSERT INTO `wp_postmeta` VALUES (2569,177,'programs_42_timings','Tuesday & Thursday -                      5:00 PM to 7:00 PM');
INSERT INTO `wp_postmeta` VALUES (2570,177,'programs_43_program_name','Pay / Session (Public Swim hour)');
INSERT INTO `wp_postmeta` VALUES (2571,177,'programs_43_timings','');
INSERT INTO `wp_postmeta` VALUES (2572,177,'programs_44_program_name','2 Days / Weekly (8 Session)');
INSERT INTO `wp_postmeta` VALUES (2573,177,'programs_44_timings','(Saturday & Sunday)  7:00 AM to 8:00 AM');
INSERT INTO `wp_postmeta` VALUES (2574,177,'programs_45_program_name','Children Yoga WE');
INSERT INTO `wp_postmeta` VALUES (2575,177,'programs_45_timings','7:30 AM');
INSERT INTO `wp_postmeta` VALUES (2576,177,'programs_46_program_name','Violin                         (Weekly 2 Days Only)');
INSERT INTO `wp_postmeta` VALUES (2577,177,'programs_46_timings','Monday, Tuesday, Thursday  -  5:00 PM to 7:00 PM    &     Sunday - 11:00 AM to 1:00 PM');
INSERT INTO `wp_postmeta` VALUES (2578,177,'programs_47_program_name','Weekdays                  (Tuesday to Friday)');
INSERT INTO `wp_postmeta` VALUES (2579,177,'programs_47_timings','10:00 AM to 11:00 AM, 12:00 AM to 1:00 PM, 9:00 PM to 10:00 PM');
INSERT INTO `wp_postmeta` VALUES (2580,177,'programs_48_program_name','Hourly Table Booking / Playo App Booking');
INSERT INTO `wp_postmeta` VALUES (2581,177,'programs_48_timings','');
INSERT INTO `wp_postmeta` VALUES (2582,177,'programs_49_program_name','Meditation & Pranayama WD');
INSERT INTO `wp_postmeta` VALUES (2583,177,'programs_49_timings','6:00 AM, 7:15 AM, 11:00 AM, 6:30 PM');
INSERT INTO `wp_postmeta` VALUES (2584,177,'programs_50_program_name','Mrudanga');
INSERT INTO `wp_postmeta` VALUES (2585,177,'programs_50_timings','Wednesday & Saturday -            5:15 PM to 6:30 PM');
INSERT INTO `wp_postmeta` VALUES (2586,177,'programs_51_program_name','Weekend                 (Saturday & Sunday)');
INSERT INTO `wp_postmeta` VALUES (2587,177,'programs_51_timings','1:00 PM to 2:00 PM,');
INSERT INTO `wp_postmeta` VALUES (2588,177,'programs_52_program_name','Weekdays (Monday to Friday)');
INSERT INTO `wp_postmeta` VALUES (2589,177,'programs_52_timings','9:00 AM to 4:00 PM,           8:00 PM to 10:00 PM');
INSERT INTO `wp_postmeta` VALUES (2590,177,'programs_53_program_name','Meditation & Pranayama WE');
INSERT INTO `wp_postmeta` VALUES (2591,177,'programs_53_timings','7:30 AM');
INSERT INTO `wp_postmeta` VALUES (2592,177,'programs_54_program_name','Flute');
INSERT INTO `wp_postmeta` VALUES (2593,177,'programs_54_timings','Thursday & Saturday   -                5:00 PM to 6:30 PM');
INSERT INTO `wp_postmeta` VALUES (2594,177,'programs_55_program_name','Weekdays                  (Tuesday to Friday) - 6:15 AM to 1:00 PM & 3:45 PM to 10:00 PM');
INSERT INTO `wp_postmeta` VALUES (2595,177,'programs_55_timings','Weekend                                (Saturday & Sunday) -               6:00 AM to 2:00 PM &               3:30 PM to 7:15 PM');
INSERT INTO `wp_postmeta` VALUES (2596,177,'programs_56_program_name','Weekend (Saturday & Sunday)');
INSERT INTO `wp_postmeta` VALUES (2597,177,'programs_56_timings','12:00 PM to 7:00 PM');
INSERT INTO `wp_postmeta` VALUES (2598,178,'phone',9481170206);
INSERT INTO `wp_postmeta` VALUES (2599,178,'area','Jayanagar');
INSERT INTO `wp_postmeta` VALUES (2600,178,'_ry_image_url','http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/rysri-kundalahalli-3-.jpg');
INSERT INTO `wp_postmeta` VALUES (2601,178,'programs',42);
INSERT INTO `wp_postmeta` VALUES (2602,178,'programs_0_program_name','Beginner');
INSERT INTO `wp_postmeta` VALUES (2603,178,'programs_0_timings','5:45 AM, 7:00 AM,.8.15 AM,9.45AM, 11:00 AM, 4:30 PM');
INSERT INTO `wp_postmeta` VALUES (2604,178,'programs_1_program_name','Light Music');
INSERT INTO `wp_postmeta` VALUES (2605,178,'programs_1_timings','Mon');
INSERT INTO `wp_postmeta` VALUES (2606,178,'programs_2_program_name','5:00 PM to 6:00 PM');
INSERT INTO `wp_postmeta` VALUES (2607,178,'programs_2_timings','');
INSERT INTO `wp_postmeta` VALUES (2608,178,'programs_3_program_name','Intermediate');
INSERT INTO `wp_postmeta` VALUES (2609,178,'programs_3_timings','7.20AM, 6.45PM');
INSERT INTO `wp_postmeta` VALUES (2610,178,'programs_4_program_name','5:00 PM to 6:00 PM');
INSERT INTO `wp_postmeta` VALUES (2611,178,'programs_4_timings','');
INSERT INTO `wp_postmeta` VALUES (2612,178,'programs_5_program_name','Senior');
INSERT INTO `wp_postmeta` VALUES (2613,178,'programs_5_timings','5:45 AM, 7:00 AM,11:00 AM, 4:30 PM, 6:30 PM');
INSERT INTO `wp_postmeta` VALUES (2614,178,'programs_6_program_name','Carnatic Sangeeta');
INSERT INTO `wp_postmeta` VALUES (2615,178,'programs_6_timings','Tue');
INSERT INTO `wp_postmeta` VALUES (2616,178,'programs_7_program_name','5:00 PM to 6:00 PM');
INSERT INTO `wp_postmeta` VALUES (2617,178,'programs_7_timings','');
INSERT INTO `wp_postmeta` VALUES (2618,178,'programs_8_program_name','General');
INSERT INTO `wp_postmeta` VALUES (2619,178,'programs_8_timings','5:45 AM, 7.00AM, 8:15 AM, 9.45AM, 11:00 AM, 4:30 PM, 6:30 PM');
INSERT INTO `wp_postmeta` VALUES (2620,178,'programs_9_program_name','5:00 PM to 6:00 PM');
INSERT INTO `wp_postmeta` VALUES (2621,178,'programs_9_timings','');
INSERT INTO `wp_postmeta` VALUES (2622,178,'programs_10_program_name','Therapy');
INSERT INTO `wp_postmeta` VALUES (2623,178,'programs_10_timings','5:45 AM, 7:00 AM,.9.30 AM,10.30 AM, 4:30 PM, 6.30PM');
INSERT INTO `wp_postmeta` VALUES (2624,178,'programs_11_program_name','Bharatanatyam');
INSERT INTO `wp_postmeta` VALUES (2625,178,'programs_11_timings','Tue');
INSERT INTO `wp_postmeta` VALUES (2626,178,'programs_12_program_name','5:30 PM to 6:30 PM');
INSERT INTO `wp_postmeta` VALUES (2627,178,'programs_12_timings','');
INSERT INTO `wp_postmeta` VALUES (2628,178,'programs_13_program_name','6:30 PM to 7:30 PM');
INSERT INTO `wp_postmeta` VALUES (2629,178,'programs_13_timings','');
INSERT INTO `wp_postmeta` VALUES (2630,178,'programs_14_program_name','5:30 PM to 6:30 PM');
INSERT INTO `wp_postmeta` VALUES (2631,178,'programs_14_timings','');
INSERT INTO `wp_postmeta` VALUES (2632,178,'programs_15_program_name','6:30 PM to 7:30 PM');
INSERT INTO `wp_postmeta` VALUES (2633,178,'programs_15_timings','');
INSERT INTO `wp_postmeta` VALUES (2634,178,'programs_16_program_name','Tabla');
INSERT INTO `wp_postmeta` VALUES (2635,178,'programs_16_timings','Sat');
INSERT INTO `wp_postmeta` VALUES (2636,178,'programs_17_program_name','3:00 PM to 4:00 PM');
INSERT INTO `wp_postmeta` VALUES (2637,178,'programs_17_timings','');
INSERT INTO `wp_postmeta` VALUES (2638,178,'programs_18_program_name','9:00 AM to 10:00 AM');
INSERT INTO `wp_postmeta` VALUES (2639,178,'programs_18_timings','');
INSERT INTO `wp_postmeta` VALUES (2640,178,'programs_19_program_name','Keyboard');
INSERT INTO `wp_postmeta` VALUES (2641,178,'programs_19_timings','Fri');
INSERT INTO `wp_postmeta` VALUES (2642,178,'programs_20_program_name','6:00 PM to 7:00 PM');
INSERT INTO `wp_postmeta` VALUES (2643,178,'programs_20_timings','');
INSERT INTO `wp_postmeta` VALUES (2644,178,'programs_21_program_name','6:00 PM to 7:00 PM');
INSERT INTO `wp_postmeta` VALUES (2645,178,'programs_21_timings','');
INSERT INTO `wp_postmeta` VALUES (2646,178,'programs_22_program_name','Veena');
INSERT INTO `wp_postmeta` VALUES (2647,178,'programs_22_timings','Wed');
INSERT INTO `wp_postmeta` VALUES (2648,178,'programs_23_program_name','4:30 PM to 5:30 PM');
INSERT INTO `wp_postmeta` VALUES (2649,178,'programs_23_timings','');
INSERT INTO `wp_postmeta` VALUES (2650,178,'programs_24_program_name','5:30 PM to 6:30 PM');
INSERT INTO `wp_postmeta` VALUES (2651,178,'programs_24_timings','');
INSERT INTO `wp_postmeta` VALUES (2652,178,'programs_25_program_name','4:30 PM to 5:30 PM');
INSERT INTO `wp_postmeta` VALUES (2653,178,'programs_25_timings','');
INSERT INTO `wp_postmeta` VALUES (2654,178,'programs_26_program_name','5:30 PM to 6:30 PM');
INSERT INTO `wp_postmeta` VALUES (2655,178,'programs_26_timings','');
INSERT INTO `wp_postmeta` VALUES (2656,178,'programs_27_program_name','Violin');
INSERT INTO `wp_postmeta` VALUES (2657,178,'programs_27_timings','Mon');
INSERT INTO `wp_postmeta` VALUES (2658,178,'programs_28_program_name','5:30 PM to 7:00 PM');
INSERT INTO `wp_postmeta` VALUES (2659,178,'programs_28_timings','');
INSERT INTO `wp_postmeta` VALUES (2660,178,'programs_29_program_name','5:30 PM to 7:00 PM');
INSERT INTO `wp_postmeta` VALUES (2661,178,'programs_29_timings','');
INSERT INTO `wp_postmeta` VALUES (2662,178,'programs_30_program_name','Flute');
INSERT INTO `wp_postmeta` VALUES (2663,178,'programs_30_timings','Fri');
INSERT INTO `wp_postmeta` VALUES (2664,178,'programs_31_program_name','5:30 PM to 6:30 PM');
INSERT INTO `wp_postmeta` VALUES (2665,178,'programs_31_timings','');
INSERT INTO `wp_postmeta` VALUES (2666,178,'programs_32_program_name','7.15 AM to 8.15 AM');
INSERT INTO `wp_postmeta` VALUES (2667,178,'programs_32_timings','');
INSERT INTO `wp_postmeta` VALUES (2668,178,'programs_33_program_name','Art Class');
INSERT INTO `wp_postmeta` VALUES (2669,178,'programs_33_timings','Sat');
INSERT INTO `wp_postmeta` VALUES (2670,178,'programs_34_program_name','4:00 PM to 5:00 PM');
INSERT INTO `wp_postmeta` VALUES (2671,178,'programs_34_timings','');
INSERT INTO `wp_postmeta` VALUES (2672,178,'programs_35_program_name','Karate');
INSERT INTO `wp_postmeta` VALUES (2673,178,'programs_35_timings','Mon');
INSERT INTO `wp_postmeta` VALUES (2674,178,'programs_36_program_name','4:30 , 5:30 , 6:30 PM');
INSERT INTO `wp_postmeta` VALUES (2675,178,'programs_36_timings','');
INSERT INTO `wp_postmeta` VALUES (2676,178,'programs_37_program_name','Samskrita Bala Kendra');
INSERT INTO `wp_postmeta` VALUES (2677,178,'programs_37_timings','Sun');
INSERT INTO `wp_postmeta` VALUES (2678,178,'programs_38_program_name','10:30 AM to 11:30 AM');
INSERT INTO `wp_postmeta` VALUES (2679,178,'programs_38_timings','');
INSERT INTO `wp_postmeta` VALUES (2680,178,'programs_39_program_name','Body Massage');
INSERT INTO `wp_postmeta` VALUES (2681,178,'programs_39_timings','');
INSERT INTO `wp_postmeta` VALUES (2682,178,'programs_40_program_name','GYM');
INSERT INTO `wp_postmeta` VALUES (2683,178,'programs_40_timings','Mon to Sat');
INSERT INTO `wp_postmeta` VALUES (2684,178,'programs_41_program_name','5.30AM to 1.30PM\n4.30PM to 9.30PM');
INSERT INTO `wp_postmeta` VALUES (2685,178,'programs_41_timings','');
INSERT INTO `wp_postmeta` VALUES (2687,180,'_wp_attached_file','2026/10/Hero-section-2.jpeg');
INSERT INTO `wp_postmeta` VALUES (2688,180,'_wp_attachment_metadata','a:6:{s:5:"width";i:1919;s:6:"height";i:1440;s:4:"file";s:27:"2026/10/Hero-section-2.jpeg";s:8:"filesize";i:1236612;s:5:"sizes";a:5:{s:6:"medium";a:5:{s:4:"file";s:27:"Hero-section-2-300x225.jpeg";s:5:"width";i:300;s:6:"height";i:225;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:31774;}s:5:"large";a:5:{s:4:"file";s:28:"Hero-section-2-1024x768.jpeg";s:5:"width";i:1024;s:6:"height";i:768;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:321303;}s:9:"thumbnail";a:5:{s:4:"file";s:27:"Hero-section-2-150x150.jpeg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:11004;}s:12:"medium_large";a:5:{s:4:"file";s:27:"Hero-section-2-768x576.jpeg";s:5:"width";i:768;s:6:"height";i:576;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:195889;}s:9:"1536x1536";a:5:{s:4:"file";s:29:"Hero-section-2-1536x1153.jpeg";s:5:"width";i:1536;s:6:"height";i:1153;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:605320;}}s:10:"image_meta";a:13:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}}');
INSERT INTO `wp_postmeta` VALUES (2691,182,'_wp_attached_file','2026/10/Hero-section-3.jpg');
INSERT INTO `wp_postmeta` VALUES (2692,182,'_wp_attachment_metadata','a:6:{s:5:"width";i:2560;s:6:"height";i:1695;s:4:"file";s:26:"2026/10/Hero-section-3.jpg";s:8:"filesize";i:655040;s:5:"sizes";a:6:{s:6:"medium";a:5:{s:4:"file";s:26:"Hero-section-3-300x199.jpg";s:5:"width";i:300;s:6:"height";i:199;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:23214;}s:5:"large";a:5:{s:4:"file";s:27:"Hero-section-3-1024x678.jpg";s:5:"width";i:1024;s:6:"height";i:678;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:156025;}s:9:"thumbnail";a:5:{s:4:"file";s:26:"Hero-section-3-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:10200;}s:12:"medium_large";a:5:{s:4:"file";s:26:"Hero-section-3-768x509.jpg";s:5:"width";i:768;s:6:"height";i:509;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:99444;}s:9:"1536x1536";a:5:{s:4:"file";s:28:"Hero-section-3-1536x1017.jpg";s:5:"width";i:1536;s:6:"height";i:1017;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:292915;}s:9:"2048x2048";a:5:{s:4:"file";s:28:"Hero-section-3-2048x1356.jpg";s:5:"width";i:2048;s:6:"height";i:1356;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:445634;}}s:10:"image_meta";a:13:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}}');
INSERT INTO `wp_postmeta` VALUES (2693,183,'_wp_attached_file','2026/10/hero-section-1.jpg');
INSERT INTO `wp_postmeta` VALUES (2694,183,'_wp_attachment_metadata','a:6:{s:5:"width";i:2160;s:6:"height";i:1440;s:4:"file";s:26:"2026/10/hero-section-1.jpg";s:8:"filesize";i:762424;s:5:"sizes";a:6:{s:6:"medium";a:5:{s:4:"file";s:26:"hero-section-1-300x200.jpg";s:5:"width";i:300;s:6:"height";i:200;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:27685;}s:5:"large";a:5:{s:4:"file";s:27:"hero-section-1-1024x683.jpg";s:5:"width";i:1024;s:6:"height";i:683;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:170854;}s:9:"thumbnail";a:5:{s:4:"file";s:26:"hero-section-1-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:12370;}s:12:"medium_large";a:5:{s:4:"file";s:26:"hero-section-1-768x512.jpg";s:5:"width";i:768;s:6:"height";i:512;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:111995;}s:9:"1536x1536";a:5:{s:4:"file";s:28:"hero-section-1-1536x1024.jpg";s:5:"width";i:1536;s:6:"height";i:1024;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:304781;}s:9:"2048x2048";a:5:{s:4:"file";s:28:"hero-section-1-2048x1365.jpg";s:5:"width";i:2048;s:6:"height";i:1365;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:462021;}}s:10:"image_meta";a:13:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}}');
INSERT INTO `wp_postmeta` VALUES (2695,184,'_wp_attached_file','2026/10/hero-section-4.jpg');
INSERT INTO `wp_postmeta` VALUES (2696,184,'_wp_attachment_metadata','a:6:{s:5:"width";i:2560;s:6:"height";i:1414;s:4:"file";s:26:"2026/10/hero-section-4.jpg";s:8:"filesize";i:783829;s:5:"sizes";a:6:{s:6:"medium";a:5:{s:4:"file";s:26:"hero-section-4-300x166.jpg";s:5:"width";i:300;s:6:"height";i:166;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:20255;}s:5:"large";a:5:{s:4:"file";s:27:"hero-section-4-1024x566.jpg";s:5:"width";i:1024;s:6:"height";i:566;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:161603;}s:9:"thumbnail";a:5:{s:4:"file";s:26:"hero-section-4-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:10048;}s:12:"medium_large";a:5:{s:4:"file";s:26:"hero-section-4-768x424.jpg";s:5:"width";i:768;s:6:"height";i:424;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:101205;}s:9:"1536x1536";a:5:{s:4:"file";s:27:"hero-section-4-1536x848.jpg";s:5:"width";i:1536;s:6:"height";i:848;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:293880;}s:9:"2048x2048";a:5:{s:4:"file";s:28:"hero-section-4-2048x1131.jpg";s:5:"width";i:2048;s:6:"height";i:1131;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:436333;}}s:10:"image_meta";a:13:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}}');
INSERT INTO `wp_postmeta` VALUES (2697,185,'_wp_attached_file','2026/10/Shri-Ajith-kumar-Founder.png');
INSERT INTO `wp_postmeta` VALUES (2698,185,'_wp_attachment_metadata','a:6:{s:5:"width";i:2541;s:6:"height";i:2560;s:4:"file";s:36:"2026/10/Shri-Ajith-kumar-Founder.png";s:8:"filesize";i:1593545;s:5:"sizes";a:6:{s:6:"medium";a:5:{s:4:"file";s:36:"Shri-Ajith-kumar-Founder-298x300.png";s:5:"width";i:298;s:6:"height";i:300;s:9:"mime-type";s:9:"image/png";s:8:"filesize";i:64026;}s:5:"large";a:5:{s:4:"file";s:38:"Shri-Ajith-kumar-Founder-1016x1024.png";s:5:"width";i:1016;s:6:"height";i:1024;s:9:"mime-type";s:9:"image/png";s:8:"filesize";i:400703;}s:9:"thumbnail";a:5:{s:4:"file";s:36:"Shri-Ajith-kumar-Founder-150x150.png";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:9:"image/png";s:8:"filesize";i:22409;}s:12:"medium_large";a:5:{s:4:"file";s:36:"Shri-Ajith-kumar-Founder-768x774.png";s:5:"width";i:768;s:6:"height";i:774;s:9:"mime-type";s:9:"image/png";s:8:"filesize";i:263542;}s:9:"1536x1536";a:5:{s:4:"file";s:38:"Shri-Ajith-kumar-Founder-1525x1536.png";s:5:"width";i:1525;s:6:"height";i:1536;s:9:"mime-type";s:9:"image/png";s:8:"filesize";i:740306;}s:9:"2048x2048";a:5:{s:4:"file";s:38:"Shri-Ajith-kumar-Founder-2033x2048.png";s:5:"width";i:2033;s:6:"height";i:2048;s:9:"mime-type";s:9:"image/png";s:8:"filesize";i:1144717;}}s:10:"image_meta";a:13:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}}');
INSERT INTO `wp_postmeta` VALUES (2699,186,'_wp_attached_file','2026/10/karate.jpg');
INSERT INTO `wp_postmeta` VALUES (2700,186,'_wp_attachment_metadata','a:6:{s:5:"width";i:558;s:6:"height";i:350;s:4:"file";s:18:"2026/10/karate.jpg";s:8:"filesize";i:23705;s:5:"sizes";a:2:{s:6:"medium";a:5:{s:4:"file";s:18:"karate-300x188.jpg";s:5:"width";i:300;s:6:"height";i:188;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:12230;}s:9:"thumbnail";a:5:{s:4:"file";s:18:"karate-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:6367;}}s:10:"image_meta";a:13:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}}');
INSERT INTO `wp_postmeta` VALUES (2701,187,'_wp_attached_file','2026/10/GYM.webp');
INSERT INTO `wp_postmeta` VALUES (2702,187,'_wp_attachment_metadata','a:6:{s:5:"width";i:1024;s:6:"height";i:682;s:4:"file";s:16:"2026/10/GYM.webp";s:8:"filesize";i:108042;s:5:"sizes";a:3:{s:6:"medium";a:5:{s:4:"file";s:16:"GYM-300x200.webp";s:5:"width";i:300;s:6:"height";i:200;s:9:"mime-type";s:10:"image/webp";s:8:"filesize";i:13570;}s:9:"thumbnail";a:5:{s:4:"file";s:16:"GYM-150x150.webp";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/webp";s:8:"filesize";i:6150;}s:12:"medium_large";a:5:{s:4:"file";s:16:"GYM-768x512.webp";s:5:"width";i:768;s:6:"height";i:512;s:9:"mime-type";s:10:"image/webp";s:8:"filesize";i:56890;}}s:10:"image_meta";a:13:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}}');
INSERT INTO `wp_postmeta` VALUES (2703,188,'_wp_attached_file','2026/10/Music.jpg');
INSERT INTO `wp_postmeta` VALUES (2704,188,'_wp_attachment_metadata','a:6:{s:5:"width";i:661;s:6:"height";i:360;s:4:"file";s:17:"2026/10/Music.jpg";s:8:"filesize";i:46153;s:5:"sizes";a:2:{s:6:"medium";a:5:{s:4:"file";s:17:"Music-300x163.jpg";s:5:"width";i:300;s:6:"height";i:163;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:9841;}s:9:"thumbnail";a:5:{s:4:"file";s:17:"Music-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:6222;}}s:10:"image_meta";a:13:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}}');
INSERT INTO `wp_postmeta` VALUES (2705,189,'_wp_attached_file','2026/10/Yoga.jpg');
INSERT INTO `wp_postmeta` VALUES (2706,189,'_wp_attachment_metadata','a:6:{s:5:"width";i:894;s:6:"height";i:592;s:4:"file";s:16:"2026/10/Yoga.jpg";s:8:"filesize";i:41891;s:5:"sizes";a:3:{s:6:"medium";a:5:{s:4:"file";s:16:"Yoga-300x199.jpg";s:5:"width";i:300;s:6:"height";i:199;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:10809;}s:9:"thumbnail";a:5:{s:4:"file";s:16:"Yoga-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:5863;}s:12:"medium_large";a:5:{s:4:"file";s:16:"Yoga-768x509.jpg";s:5:"width";i:768;s:6:"height";i:509;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:43528;}}s:10:"image_meta";a:13:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}}');
INSERT INTO `wp_postmeta` VALUES (2707,190,'_wp_attached_file','2026/10/Basavangudi.jpg');
INSERT INTO `wp_postmeta` VALUES (2708,190,'_wp_attachment_metadata','a:6:{s:5:"width";i:680;s:6:"height";i:453;s:4:"file";s:23:"2026/10/Basavangudi.jpg";s:8:"filesize";i:134220;s:5:"sizes";a:2:{s:6:"medium";a:5:{s:4:"file";s:23:"Basavangudi-300x200.jpg";s:5:"width";i:300;s:6:"height";i:200;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:21520;}s:9:"thumbnail";a:5:{s:4:"file";s:23:"Basavangudi-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:9754;}}s:10:"image_meta";a:13:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}}');
INSERT INTO `wp_postmeta` VALUES (2709,191,'_wp_attached_file','2026/10/Gayathrinagar.jpg');
INSERT INTO `wp_postmeta` VALUES (2710,191,'_wp_attachment_metadata','a:6:{s:5:"width";i:652;s:6:"height";i:377;s:4:"file";s:25:"2026/10/Gayathrinagar.jpg";s:8:"filesize";i:152582;s:5:"sizes";a:2:{s:6:"medium";a:5:{s:4:"file";s:25:"Gayathrinagar-300x173.jpg";s:5:"width";i:300;s:6:"height";i:173;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:20079;}s:9:"thumbnail";a:5:{s:4:"file";s:25:"Gayathrinagar-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:9604;}}s:10:"image_meta";a:13:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}}');
INSERT INTO `wp_postmeta` VALUES (2711,192,'_wp_attached_file','2026/10/Girinagar.jpg');
INSERT INTO `wp_postmeta` VALUES (2712,192,'_wp_attachment_metadata','a:6:{s:5:"width";i:2560;s:6:"height";i:1414;s:4:"file";s:21:"2026/10/Girinagar.jpg";s:8:"filesize";i:783829;s:5:"sizes";a:6:{s:6:"medium";a:5:{s:4:"file";s:21:"Girinagar-300x166.jpg";s:5:"width";i:300;s:6:"height";i:166;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:20255;}s:5:"large";a:5:{s:4:"file";s:22:"Girinagar-1024x566.jpg";s:5:"width";i:1024;s:6:"height";i:566;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:161603;}s:9:"thumbnail";a:5:{s:4:"file";s:21:"Girinagar-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:10048;}s:12:"medium_large";a:5:{s:4:"file";s:21:"Girinagar-768x424.jpg";s:5:"width";i:768;s:6:"height";i:424;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:101205;}s:9:"1536x1536";a:5:{s:4:"file";s:22:"Girinagar-1536x848.jpg";s:5:"width";i:1536;s:6:"height";i:848;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:293880;}s:9:"2048x2048";a:5:{s:4:"file";s:23:"Girinagar-2048x1131.jpg";s:5:"width";i:2048;s:6:"height";i:1131;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:436333;}}s:10:"image_meta";a:13:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}}');
INSERT INTO `wp_postmeta` VALUES (2713,193,'_wp_attached_file','2026/10/Jayanagara.jpg');
INSERT INTO `wp_postmeta` VALUES (2714,193,'_wp_attachment_metadata','a:6:{s:5:"width";i:360;s:6:"height";i:360;s:4:"file";s:22:"2026/10/Jayanagara.jpg";s:8:"filesize";i:44855;s:5:"sizes";a:2:{s:6:"medium";a:5:{s:4:"file";s:22:"Jayanagara-300x300.jpg";s:5:"width";i:300;s:6:"height";i:300;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:20851;}s:9:"thumbnail";a:5:{s:4:"file";s:22:"Jayanagara-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:7586;}}s:10:"image_meta";a:13:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}}');
INSERT INTO `wp_postmeta` VALUES (2715,194,'_wp_attached_file','2026/10/KAMAKSHIPALYA.jpg');
INSERT INTO `wp_postmeta` VALUES (2716,194,'_wp_attachment_metadata','a:6:{s:5:"width";i:382;s:6:"height";i:510;s:4:"file";s:25:"2026/10/KAMAKSHIPALYA.jpg";s:8:"filesize";i:89378;s:5:"sizes";a:2:{s:6:"medium";a:5:{s:4:"file";s:25:"KAMAKSHIPALYA-225x300.jpg";s:5:"width";i:225;s:6:"height";i:300;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:18699;}s:9:"thumbnail";a:5:{s:4:"file";s:25:"KAMAKSHIPALYA-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:6892;}}s:10:"image_meta";a:13:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}}');
INSERT INTO `wp_postmeta` VALUES (2717,195,'_wp_attached_file','2026/10/Kempegowda-Nagar.jpg');
INSERT INTO `wp_postmeta` VALUES (2718,195,'_wp_attachment_metadata','a:6:{s:5:"width";i:537;s:6:"height";i:510;s:4:"file";s:28:"2026/10/Kempegowda-Nagar.jpg";s:8:"filesize";i:120551;s:5:"sizes";a:2:{s:6:"medium";a:5:{s:4:"file";s:28:"Kempegowda-Nagar-300x285.jpg";s:5:"width";i:300;s:6:"height";i:285;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:26942;}s:9:"thumbnail";a:5:{s:4:"file";s:28:"Kempegowda-Nagar-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:8525;}}s:10:"image_meta";a:13:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}}');
INSERT INTO `wp_postmeta` VALUES (2719,196,'_wp_attached_file','2026/10/Kundalahalli.jpg');
INSERT INTO `wp_postmeta` VALUES (2720,196,'_wp_attachment_metadata','a:6:{s:5:"width";i:1069;s:6:"height";i:816;s:4:"file";s:24:"2026/10/Kundalahalli.jpg";s:8:"filesize";i:365593;s:5:"sizes";a:4:{s:6:"medium";a:5:{s:4:"file";s:24:"Kundalahalli-300x229.jpg";s:5:"width";i:300;s:6:"height";i:229;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:25270;}s:5:"large";a:5:{s:4:"file";s:25:"Kundalahalli-1024x782.jpg";s:5:"width";i:1024;s:6:"height";i:782;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:199271;}s:9:"thumbnail";a:5:{s:4:"file";s:24:"Kundalahalli-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:9409;}s:12:"medium_large";a:5:{s:4:"file";s:24:"Kundalahalli-768x586.jpg";s:5:"width";i:768;s:6:"height";i:586;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:126052;}}s:10:"image_meta";a:13:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}}');
INSERT INTO `wp_postmeta` VALUES (2721,197,'_wp_attached_file','2026/10/nagarbhavi.jpg');
INSERT INTO `wp_postmeta` VALUES (2722,197,'_wp_attachment_metadata','a:6:{s:5:"width";i:680;s:6:"height";i:306;s:4:"file";s:22:"2026/10/nagarbhavi.jpg";s:8:"filesize";i:112146;s:5:"sizes";a:2:{s:6:"medium";a:5:{s:4:"file";s:22:"nagarbhavi-300x135.jpg";s:5:"width";i:300;s:6:"height";i:135;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:15684;}s:9:"thumbnail";a:5:{s:4:"file";s:22:"nagarbhavi-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:9321;}}s:10:"image_meta";a:13:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}}');
INSERT INTO `wp_postmeta` VALUES (2723,198,'_wp_attached_file','2026/10/RBI-Layout.jpg');
INSERT INTO `wp_postmeta` VALUES (2724,198,'_wp_attachment_metadata','a:6:{s:5:"width";i:382;s:6:"height";i:510;s:4:"file";s:22:"2026/10/RBI-Layout.jpg";s:8:"filesize";i:124608;s:5:"sizes";a:2:{s:6:"medium";a:5:{s:4:"file";s:22:"RBI-Layout-225x300.jpg";s:5:"width";i:225;s:6:"height";i:300;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:27572;}s:9:"thumbnail";a:5:{s:4:"file";s:22:"RBI-Layout-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:10651;}}s:10:"image_meta";a:13:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}}');
INSERT INTO `wp_postmeta` VALUES (2725,199,'_wp_attached_file','2026/10/Sadashivnagar.jpg');
INSERT INTO `wp_postmeta` VALUES (2726,199,'_wp_attachment_metadata','a:6:{s:5:"width";i:680;s:6:"height";i:510;s:4:"file";s:25:"2026/10/Sadashivnagar.jpg";s:8:"filesize";i:211792;s:5:"sizes";a:2:{s:6:"medium";a:5:{s:4:"file";s:25:"Sadashivnagar-300x225.jpg";s:5:"width";i:300;s:6:"height";i:225;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:27201;}s:9:"thumbnail";a:5:{s:4:"file";s:25:"Sadashivnagar-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:9930;}}s:10:"image_meta";a:13:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}}');
INSERT INTO `wp_postmeta` VALUES (2727,200,'_wp_attached_file','2026/10/Vijaynagar.jpg');
INSERT INTO `wp_postmeta` VALUES (2728,200,'_wp_attachment_metadata','a:6:{s:5:"width";i:680;s:6:"height";i:510;s:4:"file";s:22:"2026/10/Vijaynagar.jpg";s:8:"filesize";i:127503;s:5:"sizes";a:2:{s:6:"medium";a:5:{s:4:"file";s:22:"Vijaynagar-300x225.jpg";s:5:"width";i:300;s:6:"height";i:225;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:18260;}s:9:"thumbnail";a:5:{s:4:"file";s:22:"Vijaynagar-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:7024;}}s:10:"image_meta";a:13:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}}');
INSERT INTO `wp_postmeta` VALUES (2729,201,'_wp_attached_file','2026/10/evolution.jpeg');
INSERT INTO `wp_postmeta` VALUES (2730,201,'_wp_attachment_metadata','a:6:{s:5:"width";i:640;s:6:"height";i:480;s:4:"file";s:22:"2026/10/evolution.jpeg";s:8:"filesize";i:57033;s:5:"sizes";a:2:{s:6:"medium";a:5:{s:4:"file";s:22:"evolution-300x225.jpeg";s:5:"width";i:300;s:6:"height";i:225;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:20183;}s:9:"thumbnail";a:5:{s:4:"file";s:22:"evolution-150x150.jpeg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:8115;}}s:10:"image_meta";a:13:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}}');
INSERT INTO `wp_postmeta` VALUES (2731,202,'_wp_attached_file','2026/10/History.png');
INSERT INTO `wp_postmeta` VALUES (2732,202,'_wp_attachment_metadata','a:6:{s:5:"width";i:980;s:6:"height";i:980;s:4:"file";s:19:"2026/10/History.png";s:8:"filesize";i:1623308;s:5:"sizes";a:3:{s:6:"medium";a:5:{s:4:"file";s:19:"History-300x300.png";s:5:"width";i:300;s:6:"height";i:300;s:9:"mime-type";s:9:"image/png";s:8:"filesize";i:178476;}s:9:"thumbnail";a:5:{s:4:"file";s:19:"History-150x150.png";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:9:"image/png";s:8:"filesize";i:47720;}s:12:"medium_large";a:5:{s:4:"file";s:19:"History-768x768.png";s:5:"width";i:768;s:6:"height";i:768;s:9:"mime-type";s:9:"image/png";s:8:"filesize";i:1019512;}}s:10:"image_meta";a:13:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}}');
INSERT INTO `wp_postmeta` VALUES (2733,203,'_wp_attached_file','2026/10/Sri-Dinesh-Hegde-General-Secretary.png');
INSERT INTO `wp_postmeta` VALUES (2734,203,'_wp_attachment_metadata','a:6:{s:5:"width";i:428;s:6:"height";i:500;s:4:"file";s:46:"2026/10/Sri-Dinesh-Hegde-General-Secretary.png";s:8:"filesize";i:220920;s:5:"sizes";a:2:{s:6:"medium";a:5:{s:4:"file";s:46:"Sri-Dinesh-Hegde-General-Secretary-257x300.png";s:5:"width";i:257;s:6:"height";i:300;s:9:"mime-type";s:9:"image/png";s:8:"filesize";i:92494;}s:9:"thumbnail";a:5:{s:4:"file";s:46:"Sri-Dinesh-Hegde-General-Secretary-150x150.png";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:9:"image/png";s:8:"filesize";i:33886;}}s:10:"image_meta";a:13:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}}');
INSERT INTO `wp_postmeta` VALUES (2735,204,'_wp_attached_file','2026/10/Sri-K-S-Narayan-Treasurer.jpg');
INSERT INTO `wp_postmeta` VALUES (2736,204,'_wp_attachment_metadata','a:6:{s:5:"width";i:428;s:6:"height";i:500;s:4:"file";s:37:"2026/10/Sri-K-S-Narayan-Treasurer.jpg";s:8:"filesize";i:30245;s:5:"sizes";a:2:{s:6:"medium";a:5:{s:4:"file";s:37:"Sri-K-S-Narayan-Treasurer-257x300.jpg";s:5:"width";i:257;s:6:"height";i:300;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:11752;}s:9:"thumbnail";a:5:{s:4:"file";s:37:"Sri-K-S-Narayan-Treasurer-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:5012;}}s:10:"image_meta";a:13:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}}');
INSERT INTO `wp_postmeta` VALUES (2737,205,'_wp_attached_file','2026/10/Sri-M-P-Kumar-President.png');
INSERT INTO `wp_postmeta` VALUES (2738,205,'_wp_attachment_metadata','a:6:{s:5:"width";i:428;s:6:"height";i:500;s:4:"file";s:35:"2026/10/Sri-M-P-Kumar-President.png";s:8:"filesize";i:248921;s:5:"sizes";a:2:{s:6:"medium";a:5:{s:4:"file";s:35:"Sri-M-P-Kumar-President-257x300.png";s:5:"width";i:257;s:6:"height";i:300;s:9:"mime-type";s:9:"image/png";s:8:"filesize";i:106130;}s:9:"thumbnail";a:5:{s:4:"file";s:35:"Sri-M-P-Kumar-President-150x150.png";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:9:"image/png";s:8:"filesize";i:38280;}}s:10:"image_meta";a:13:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}}');
INSERT INTO `wp_postmeta` VALUES (2739,206,'_wp_attached_file','2026/10/12th-IDY.jpeg');
INSERT INTO `wp_postmeta` VALUES (2740,206,'_wp_attachment_metadata','a:6:{s:5:"width";i:1169;s:6:"height";i:512;s:4:"file";s:21:"2026/10/12th-IDY.jpeg";s:8:"filesize";i:154531;s:5:"sizes";a:4:{s:6:"medium";a:5:{s:4:"file";s:21:"12th-IDY-300x131.jpeg";s:5:"width";i:300;s:6:"height";i:131;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:15741;}s:5:"large";a:5:{s:4:"file";s:22:"12th-IDY-1024x448.jpeg";s:5:"width";i:1024;s:6:"height";i:448;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:121307;}s:9:"thumbnail";a:5:{s:4:"file";s:21:"12th-IDY-150x150.jpeg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:9237;}s:12:"medium_large";a:5:{s:4:"file";s:21:"12th-IDY-768x336.jpeg";s:5:"width";i:768;s:6:"height";i:336;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:77798;}}s:10:"image_meta";a:13:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}}');
INSERT INTO `wp_postmeta` VALUES (2741,207,'_wp_attached_file','2026/10/Chess-tournament.jpg');
INSERT INTO `wp_postmeta` VALUES (2742,207,'_wp_attachment_metadata','a:6:{s:5:"width";i:780;s:6:"height";i:512;s:4:"file";s:28:"2026/10/Chess-tournament.jpg";s:8:"filesize";i:56819;s:5:"sizes";a:3:{s:6:"medium";a:5:{s:4:"file";s:28:"Chess-tournament-300x197.jpg";s:5:"width";i:300;s:6:"height";i:197;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:13726;}s:9:"thumbnail";a:5:{s:4:"file";s:28:"Chess-tournament-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:6011;}s:12:"medium_large";a:5:{s:4:"file";s:28:"Chess-tournament-768x504.jpg";s:5:"width";i:768;s:6:"height";i:504;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:54806;}}s:10:"image_meta";a:13:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}}');
INSERT INTO `wp_postmeta` VALUES (2743,208,'_wp_attached_file','2026/10/ISRO-chairman-NEWS-image.jpg');
INSERT INTO `wp_postmeta` VALUES (2744,208,'_wp_attachment_metadata','a:6:{s:5:"width";i:884;s:6:"height";i:512;s:4:"file";s:36:"2026/10/ISRO-chairman-NEWS-image.jpg";s:8:"filesize";i:67959;s:5:"sizes";a:3:{s:6:"medium";a:5:{s:4:"file";s:36:"ISRO-chairman-NEWS-image-300x174.jpg";s:5:"width";i:300;s:6:"height";i:174;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:12838;}s:9:"thumbnail";a:5:{s:4:"file";s:36:"ISRO-chairman-NEWS-image-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:7298;}s:12:"medium_large";a:5:{s:4:"file";s:36:"ISRO-chairman-NEWS-image-768x445.jpg";s:5:"width";i:768;s:6:"height";i:445;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:53187;}}s:10:"image_meta";a:13:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}}');
INSERT INTO `wp_postmeta` VALUES (2745,209,'_wp_attached_file','2026/10/Yoga-Prashikshana-scaled.jpg');
INSERT INTO `wp_postmeta` VALUES (2746,209,'_wp_attachment_metadata','a:7:{s:5:"width";i:2560;s:6:"height";i:1707;s:4:"file";s:36:"2026/10/Yoga-Prashikshana-scaled.jpg";s:8:"filesize";i:560839;s:5:"sizes";a:6:{s:6:"medium";a:5:{s:4:"file";s:29:"Yoga-Prashikshana-300x200.jpg";s:5:"width";i:300;s:6:"height";i:200;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:17485;}s:5:"large";a:5:{s:4:"file";s:30:"Yoga-Prashikshana-1024x683.jpg";s:5:"width";i:1024;s:6:"height";i:683;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:131357;}s:9:"thumbnail";a:5:{s:4:"file";s:29:"Yoga-Prashikshana-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:7723;}s:12:"medium_large";a:5:{s:4:"file";s:29:"Yoga-Prashikshana-768x512.jpg";s:5:"width";i:768;s:6:"height";i:512;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:82027;}s:9:"1536x1536";a:5:{s:4:"file";s:31:"Yoga-Prashikshana-1536x1024.jpg";s:5:"width";i:1536;s:6:"height";i:1024;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:250725;}s:9:"2048x2048";a:5:{s:4:"file";s:31:"Yoga-Prashikshana-2048x1365.jpg";s:5:"width";i:2048;s:6:"height";i:1365;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:395560;}}s:10:"image_meta";a:13:{s:8:"aperture";s:1:"4";s:6:"credit";s:0:"";s:6:"camera";s:14:"Canon EOS R6m2";s:7:"caption";s:0:"";s:17:"created_timestamp";s:10:"1783844492";s:9:"copyright";s:0:"";s:12:"focal_length";s:2:"35";s:3:"iso";s:4:"2500";s:13:"shutter_speed";s:5:"0.005";s:5:"title";s:0:"";s:11:"orientation";s:1:"1";s:8:"keywords";a:0:{}s:3:"alt";s:0:"";}s:14:"original_image";s:21:"Yoga-Prashikshana.jpg";}');
INSERT INTO `wp_postmeta` VALUES (2747,210,'_thumbnail_id',206);
INSERT INTO `wp_postmeta` VALUES (2748,210,'_ry_image_url','http://localhost:8881/wp-content/uploads/2026/10/12th-IDY.jpeg');
INSERT INTO `wp_postmeta` VALUES (2749,210,'event_date','2026-06-21');
INSERT INTO `wp_postmeta` VALUES (2750,210,'_ry_event_date','2026-06-21');
INSERT INTO `wp_postmeta` VALUES (2751,210,'event_time','6:00 AM - 9:00 AM');
INSERT INTO `wp_postmeta` VALUES (2752,210,'_ry_start_time','6:00 AM');
INSERT INTO `wp_postmeta` VALUES (2753,210,'_ry_end_time','9:00 AM');
INSERT INTO `wp_postmeta` VALUES (2754,210,'event_venue_custom','20+ Rashtrotthana Yoga Centres');
INSERT INTO `wp_postmeta` VALUES (2755,210,'_ry_event_venue','20+ Rashtrotthana Yoga Centres');
INSERT INTO `wp_postmeta` VALUES (2756,210,'event_fee','Free & Open for All');
INSERT INTO `wp_postmeta` VALUES (2757,210,'_ry_event_fee','Free & Open for All');
INSERT INTO `wp_postmeta` VALUES (2758,210,'event_mode','In-Person & Online');
INSERT INTO `wp_postmeta` VALUES (2759,210,'_ry_event_mode','In-Person & Online');
INSERT INTO `wp_postmeta` VALUES (2760,210,'_ry_event_category','Special Events');
INSERT INTO `wp_postmeta` VALUES (2761,210,'_ry_event_type','upcoming');
INSERT INTO `wp_postmeta` VALUES (2762,211,'_thumbnail_id',207);
INSERT INTO `wp_postmeta` VALUES (2763,211,'_ry_image_url','http://localhost:8881/wp-content/uploads/2026/10/Chess-tournament.jpg');
INSERT INTO `wp_postmeta` VALUES (2764,211,'event_date','2026-06-28');
INSERT INTO `wp_postmeta` VALUES (2765,211,'_ry_event_date','2026-06-28');
INSERT INTO `wp_postmeta` VALUES (2766,211,'event_time','9:00 AM - 5:00 PM');
INSERT INTO `wp_postmeta` VALUES (2767,211,'_ry_start_time','9:00 AM');
INSERT INTO `wp_postmeta` VALUES (2768,211,'_ry_end_time','5:00 PM');
INSERT INTO `wp_postmeta` VALUES (2769,211,'event_venue_custom','ಬಸವನಗುಡಿ ರಾಷ್ಟ್ರೋತ್ಥಾನ ಯೋಗಕೇಂದ್ರ (Basavanagudi)');
INSERT INTO `wp_postmeta` VALUES (2770,211,'_ry_event_venue','ಬಸವನಗುಡಿ ರಾಷ್ಟ್ರೋತ್ಥಾನ ಯೋಗಕೇಂದ್ರ (Basavanagudi)');
INSERT INTO `wp_postmeta` VALUES (2771,211,'event_fee','Tournament Entry');
INSERT INTO `wp_postmeta` VALUES (2772,211,'_ry_event_fee','Tournament Entry');
INSERT INTO `wp_postmeta` VALUES (2773,211,'event_mode','In-Person Tournament');
INSERT INTO `wp_postmeta` VALUES (2774,211,'_ry_event_mode','In-Person Tournament');
INSERT INTO `wp_postmeta` VALUES (2775,211,'_ry_event_category','Children & Youth');
INSERT INTO `wp_postmeta` VALUES (2776,211,'_ry_event_type','upcoming');
INSERT INTO `wp_postmeta` VALUES (2777,212,'_thumbnail_id',208);
INSERT INTO `wp_postmeta` VALUES (2778,212,'_ry_image_url','http://localhost:8881/wp-content/uploads/2026/10/ISRO-chairman-NEWS-image.jpg');
INSERT INTO `wp_postmeta` VALUES (2779,212,'_ry_read_time','2 min read');
INSERT INTO `wp_postmeta` VALUES (2780,210,'_ry_registration_status','closed');
INSERT INTO `wp_postmeta` VALUES (2781,210,'registration_status','closed');
INSERT INTO `wp_postmeta` VALUES (2782,211,'_ry_registration_status','open');
INSERT INTO `wp_postmeta` VALUES (2783,211,'registration_status','open');

--
-- Table structure for table `wp_posts`
--

DROP TABLE IF EXISTS `wp_posts`;
CREATE TABLE `wp_posts` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_author` bigint(20) unsigned NOT NULL DEFAULT '0',
  `post_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content` longtext NOT NULL,
  `post_title` text NOT NULL,
  `post_excerpt` text NOT NULL,
  `post_status` varchar(20) NOT NULL DEFAULT 'publish',
  `comment_status` varchar(20) NOT NULL DEFAULT 'open',
  `ping_status` varchar(20) NOT NULL DEFAULT 'open',
  `post_password` varchar(255) NOT NULL DEFAULT '',
  `post_name` varchar(200) NOT NULL DEFAULT '',
  `to_ping` text NOT NULL,
  `pinged` text NOT NULL,
  `post_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_modified_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content_filtered` longtext NOT NULL,
  `post_parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `guid` varchar(255) NOT NULL DEFAULT '',
  `menu_order` int(11) NOT NULL DEFAULT '0',
  `post_type` varchar(20) NOT NULL DEFAULT 'post',
  `post_mime_type` varchar(100) NOT NULL DEFAULT '',
  `comment_count` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `post_name` (`post_name`(191)),
  KEY `type_status_date` (`post_type`, `post_status`, `post_date`, `ID`),
  KEY `post_parent` (`post_parent`),
  KEY `post_author` (`post_author`),
  KEY `type_status_author` (`post_type`, `post_status`, `post_author`)
) ENGINE=InnoDB AUTO_INCREMENT=213 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `wp_posts`
--

INSERT INTO `wp_posts` VALUES (2,1,'2026-08-28 14:57:36','2026-08-28 14:57:36','<!-- wp:paragraph -->\n<p>This is an example page. It\'s different from a blog post because it will stay in one place and will show up in your site navigation (in most themes). Most people start with an About page that introduces them to potential site visitors. It might say something like this:</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:quote -->\n<blockquote class="wp-block-quote">\n<!-- wp:paragraph -->\n<p>Hi there! I\'m a bike messenger by day, aspiring actor by night, and this is my website. I live in Los Angeles, have a great dog named Jack, and I like pi&#241;a coladas. (And gettin\' caught in the rain.)</p>\n<!-- /wp:paragraph -->\n</blockquote>\n<!-- /wp:quote -->\n\n<!-- wp:paragraph -->\n<p>...or something like this:</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:quote -->\n<blockquote class="wp-block-quote">\n<!-- wp:paragraph -->\n<p>The XYZ Doohickey Company was founded in 1971, and has been providing quality doohickeys to the public ever since. Located in Gotham City, XYZ employs over 2,000 people and does all kinds of awesome things for the Gotham community.</p>\n<!-- /wp:paragraph -->\n</blockquote>\n<!-- /wp:quote -->\n\n<!-- wp:paragraph -->\n<p>As a new WordPress user, you should go to <a href="http://localhost:8881/wp-admin/">your dashboard</a> to delete this page and create new pages for your content. Have fun!</p>\n<!-- /wp:paragraph -->','Sample Page','','publish','closed','open','','sample-page','','','2026-08-28 14:57:36','2026-08-28 14:57:36','',0,'http://localhost:8881/?page_id=2',0,'page','',0);
INSERT INTO `wp_posts` VALUES (3,1,'2026-08-28 14:57:36','2026-08-28 14:57:36','<!-- wp:heading -->\n<h2 class="wp-block-heading">Who we are</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class="privacy-policy-tutorial">Suggested text: </strong>Our website address is: http://localhost:8881.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class="wp-block-heading">Comments</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class="privacy-policy-tutorial">Suggested text: </strong>When visitors leave comments on the site we collect the data shown in the comments form, and also the visitor&#8217;s IP address and browser user agent string to help spam detection.</p>\n<!-- /wp:paragraph -->\n<!-- wp:paragraph -->\n<p>An anonymized string created from your email address (also called a hash) may be provided to the Gravatar service to see if you are using it. The Gravatar service privacy policy is available here: https://automattic.com/privacy/. After approval of your comment, your profile picture is visible to the public in the context of your comment.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class="wp-block-heading">Media</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class="privacy-policy-tutorial">Suggested text: </strong>If you upload images to the website, you should avoid uploading images with embedded location data (EXIF GPS) included. Visitors to the website can download and extract any location data from images on the website.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class="wp-block-heading">Cookies</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class="privacy-policy-tutorial">Suggested text: </strong>If you leave a comment on our site you may opt-in to saving your name, email address and website in cookies. These are for your convenience so that you do not have to fill in your details again when you leave another comment. These cookies will last for one year.</p>\n<!-- /wp:paragraph -->\n<!-- wp:paragraph -->\n<p>If you visit our login page, we will set a temporary cookie to determine if your browser accepts cookies. This cookie contains no personal data and is discarded when you close your browser.</p>\n<!-- /wp:paragraph -->\n<!-- wp:paragraph -->\n<p>When you log in, we will also set up several cookies to save your login information and your screen display choices. Login cookies last for two days, and screen options cookies last for a year. If you select &quot;Remember Me&quot;, your login will persist for two weeks. If you log out of your account, the login cookies will be removed.</p>\n<!-- /wp:paragraph -->\n<!-- wp:paragraph -->\n<p>If you edit or publish an article, an additional cookie will be saved in your browser. This cookie includes no personal data and simply indicates the post ID of the article you just edited. It expires after 1 day.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class="wp-block-heading">Embedded content from other websites</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class="privacy-policy-tutorial">Suggested text: </strong>Articles on this site may include embedded content (e.g. videos, images, articles, etc.). Embedded content from other websites behaves in the exact same way as if the visitor has visited the other website.</p>\n<!-- /wp:paragraph -->\n<!-- wp:paragraph -->\n<p>These websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with that embedded content, including tracking your interaction with the embedded content if you have an account and are logged in to that website.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class="wp-block-heading">Who we share your data with</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class="privacy-policy-tutorial">Suggested text: </strong>If you request a password reset, your IP address will be included in the reset email.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class="wp-block-heading">How long we retain your data</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class="privacy-policy-tutorial">Suggested text: </strong>If you leave a comment, the comment and its metadata are retained indefinitely. This is so we can recognize and approve any follow-up comments automatically instead of holding them in a moderation queue.</p>\n<!-- /wp:paragraph -->\n<!-- wp:paragraph -->\n<p>For users that register on our website (if any), we also store the personal information they provide in their user profile. All users can see, edit, or delete their personal information at any time (except they cannot change their username). Website administrators can also see and edit that information.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class="wp-block-heading">What rights you have over your data</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class="privacy-policy-tutorial">Suggested text: </strong>If you have an account on this site, or have left comments, you can request to receive an exported file of the personal data we hold about you, including any data you have provided to us. You can also request that we erase any personal data we hold about you. This does not include any data we are obliged to keep for administrative, legal, or security purposes.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class="wp-block-heading">Where your data is sent</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class="privacy-policy-tutorial">Suggested text: </strong>Visitor comments may be checked through an automated spam detection service.</p>\n<!-- /wp:paragraph -->\n','Privacy Policy','','draft','closed','open','','privacy-policy','','','2026-08-28 14:57:36','2026-08-28 14:57:36','',0,'http://localhost:8881/?page_id=3',0,'page','',0);
INSERT INTO `wp_posts` VALUES (4,0,'2026-08-28 14:57:43','2026-08-28 14:57:43','<!-- wp:page-list /-->','Navigation','','publish','closed','closed','','navigation','','','2026-08-28 14:57:43','2026-08-28 14:57:43','',0,'http://localhost:8881/2026/08/28/navigation/',0,'wp_navigation','',0);
INSERT INTO `wp_posts` VALUES (5,0,'2026-09-21 18:36:17','2026-09-21 18:36:17','[ry_ongoing_events]','Ongoing Registrations','','publish','closed','closed','','ongoing-registrations','','','2026-09-21 18:36:17','2026-09-21 18:36:17','',0,'http://localhost:8881/ongoing-registrations/',0,'page','',0);
INSERT INTO `wp_posts` VALUES (43,0,'2026-09-22 13:29:37','2026-09-22 13:29:37','Category: yoga-wellness\nBadge: Foundational','Yoga for Beginners (Sarala Yoga)','','publish','closed','closed','','yoga-for-beginners-sarala-yoga','','','2026-09-22 13:29:37','2026-09-22 13:29:37','',0,'http://localhost:8881/activities/yoga-for-beginners-sarala-yoga/',0,'activity','',0);
INSERT INTO `wp_posts` VALUES (44,0,'2026-09-22 13:29:37','2026-09-22 13:29:37','Category: yoga-wellness\nBadge: Daily Batches','Yoga for All (Samanya & Advanced Yoga)','','publish','closed','closed','','yoga-for-all-samanya-advanced-yoga','','','2026-09-22 13:29:37','2026-09-22 13:29:37','',0,'http://localhost:8881/activities/yoga-for-all-samanya-advanced-yoga/',0,'activity','',0);
INSERT INTO `wp_posts` VALUES (45,0,'2026-09-22 13:29:37','2026-09-22 13:29:37','Category: yoga-wellness\nBadge: Therapeutic','Yoga Therapy Sessions (Yoga Chikitsa)','','publish','closed','closed','','yoga-therapy-sessions-yoga-chikitsa','','','2026-09-22 13:29:37','2026-09-22 13:29:37','',0,'http://localhost:8881/activities/yoga-therapy-sessions-yoga-chikitsa/',0,'activity','',0);
INSERT INTO `wp_posts` VALUES (46,0,'2026-09-22 13:29:37','2026-09-22 13:29:37','Category: yoga-wellness\nBadge: Specialized Care','Prenatal & Postnatal Yoga Care','','publish','closed','closed','','prenatal-postnatal-yoga-care','','','2026-09-22 13:29:37','2026-09-22 13:29:37','',0,'http://localhost:8881/activities/prenatal-postnatal-yoga-care/',0,'activity','',0);
INSERT INTO `wp_posts` VALUES (47,0,'2026-09-22 13:29:37','2026-09-22 13:29:37','Category: arts-music\nBadge: Classical Vocal','Carnatic Classical Vocal','','publish','closed','closed','','carnatic-classical-vocal','','','2026-09-22 13:29:37','2026-09-22 13:29:37','',0,'http://localhost:8881/activities/carnatic-classical-vocal/',0,'activity','',0);
INSERT INTO `wp_posts` VALUES (48,0,'2026-09-22 13:29:37','2026-09-22 13:29:37','Category: arts-music\nBadge: Instrumental','Keyboard Lessons (Classical & Western)','','publish','closed','closed','','keyboard-lessons-classical-western','','','2026-09-22 13:29:37','2026-09-22 13:29:37','',0,'http://localhost:8881/activities/keyboard-lessons-classical-western/',0,'activity','',0);
INSERT INTO `wp_posts` VALUES (49,0,'2026-09-22 13:29:37','2026-09-22 13:29:37','Category: arts-music\nBadge: Vocal','Light Music (Sugama Sangeetha)','','publish','closed','closed','','light-music-sugama-sangeetha','','','2026-09-22 13:29:37','2026-09-22 13:29:37','',0,'http://localhost:8881/activities/light-music-sugama-sangeetha/',0,'activity','',0);
INSERT INTO `wp_posts` VALUES (50,0,'2026-09-22 13:29:37','2026-09-22 13:29:37','Category: arts-music\nBadge: Instrumental','Flute (Classical Bansuri)','','publish','closed','closed','','flute-classical-bansuri','','','2026-09-22 13:29:37','2026-09-22 13:29:37','',0,'http://localhost:8881/activities/flute-classical-bansuri/',0,'activity','',0);
INSERT INTO `wp_posts` VALUES (51,0,'2026-09-22 13:29:37','2026-09-22 13:29:37','Category: dance\nBadge: Classical','Bharatanatyam (Kalakshetra / Pandanallur)','','publish','closed','closed','','bharatanatyam-kalakshetra-pandanallur','','','2026-09-22 13:29:37','2026-09-22 13:29:37','',0,'http://localhost:8881/activities/bharatanatyam-kalakshetra-pandanallur/',0,'activity','',0);
INSERT INTO `wp_posts` VALUES (52,0,'2026-09-22 13:29:37','2026-09-22 13:29:37','Category: dance\nBadge: Classical','Kathak (North Indian Classical)','','publish','closed','closed','','kathak-north-indian-classical','','','2026-09-22 13:29:37','2026-09-22 13:29:37','',0,'http://localhost:8881/activities/kathak-north-indian-classical/',0,'activity','',0);
INSERT INTO `wp_posts` VALUES (53,0,'2026-09-22 13:29:37','2026-09-22 13:29:37','Category: dance\nBadge: Folk Heritage','Folk Dance (Janapada Nritya)','','publish','closed','closed','','folk-dance-janapada-nritya','','','2026-09-22 13:29:37','2026-09-22 13:29:37','',0,'http://localhost:8881/activities/folk-dance-janapada-nritya/',0,'activity','',0);
INSERT INTO `wp_posts` VALUES (54,0,'2026-09-22 13:29:37','2026-09-22 13:29:37','Category: dance\nBadge: Modern Movement','Contemporary Dance & Creative Movement','','publish','closed','closed','','contemporary-dance-creative-movement','','','2026-09-22 13:29:37','2026-09-22 13:29:37','',0,'http://localhost:8881/activities/contemporary-dance-creative-movement/',0,'activity','',0);
INSERT INTO `wp_posts` VALUES (55,0,'2026-09-22 13:29:37','2026-09-22 13:29:37','Category: martial-arts\nBadge: All Belts','Karate (Shotokan / Goju-Ryu)','','publish','closed','closed','','karate-shotokan-goju-ryu','','','2026-09-22 13:29:37','2026-09-22 13:29:37','',0,'http://localhost:8881/activities/karate-shotokan-goju-ryu/',0,'activity','',0);
INSERT INTO `wp_posts` VALUES (56,0,'2026-09-22 13:29:37','2026-09-22 13:29:37','Category: martial-arts\nBadge: Agility & Sparring','Taekwondo (Korean Martial Art)','','publish','closed','closed','','taekwondo-korean-martial-art','','','2026-09-22 13:29:37','2026-09-22 13:29:37','',0,'http://localhost:8881/activities/taekwondo-korean-martial-art/',0,'activity','',0);
INSERT INTO `wp_posts` VALUES (57,0,'2026-09-22 13:29:37','2026-09-22 13:29:37','Category: martial-arts\nBadge: Traditional','Kalaripayattu (Ancient Indian Martial Art)','','publish','closed','closed','','kalaripayattu-ancient-indian-martial-art','','','2026-09-22 13:29:37','2026-09-22 13:29:37','',0,'http://localhost:8881/activities/kalaripayattu-ancient-indian-martial-art/',0,'activity','',0);
INSERT INTO `wp_posts` VALUES (58,0,'2026-09-22 13:29:37','2026-09-22 13:29:37','Category: martial-arts\nBadge: Modular Workshops','Self Defence Workshops','','publish','closed','closed','','self-defence-workshops','','','2026-09-22 13:29:37','2026-09-22 13:29:37','',0,'http://localhost:8881/activities/self-defence-workshops/',0,'activity','',0);
INSERT INTO `wp_posts` VALUES (59,0,'2026-09-22 13:29:37','2026-09-22 13:29:37','Category: children-programs\nBadge: Ages 5-12','Samskrita Bala Kendra','','publish','closed','closed','','samskrita-bala-kendra','','','2026-09-22 13:29:37','2026-09-22 13:29:37','',0,'http://localhost:8881/activities/samskrita-bala-kendra/',0,'activity','',0);
INSERT INTO `wp_posts` VALUES (60,0,'2026-09-22 13:29:37','2026-09-22 13:29:37','Category: children-programs\nBadge: Weekly Mentorship','Bala Samskara Kendra','','publish','closed','closed','','bala-samskara-kendra','','','2026-09-22 13:29:37','2026-09-22 13:29:37','',0,'http://localhost:8881/activities/bala-samskara-kendra/',0,'activity','',0);
INSERT INTO `wp_posts` VALUES (61,0,'2026-09-22 13:29:37','2026-09-22 13:29:37','Category: children-programs\nBadge: Teens & Youth','Personality Development & Public Speaking','','publish','closed','closed','','personality-development-public-speaking','','','2026-09-22 13:29:37','2026-09-22 13:29:37','',0,'http://localhost:8881/activities/personality-development-public-speaking/',0,'activity','',0);
INSERT INTO `wp_posts` VALUES (62,0,'2026-09-22 13:29:37','2026-09-22 13:29:37','Category: children-programs\nBadge: Holiday Camps','Summer & Vacation Camps','','publish','closed','closed','','summer-vacation-camps','','','2026-09-22 13:29:37','2026-09-22 13:29:37','',0,'http://localhost:8881/activities/summer-vacation-camps/',0,'activity','',0);
INSERT INTO `wp_posts` VALUES (63,0,'2026-09-22 13:29:37','2026-09-22 13:29:37','Category: fitness-sports\nBadge: Coached Fitness','Modern Gym & Strength Conditioning','','publish','closed','closed','','modern-gym-strength-conditioning','','','2026-09-22 13:29:37','2026-09-22 13:29:37','',0,'http://localhost:8881/activities/modern-gym-strength-conditioning/',0,'activity','',0);
INSERT INTO `wp_posts` VALUES (64,0,'2026-09-22 13:29:37','2026-09-22 13:29:37','Category: fitness-sports\nBadge: All Levels','Swimming Pool & Professional Coaching','','publish','closed','closed','','swimming-pool-professional-coaching','','','2026-09-22 13:29:37','2026-09-22 13:29:37','',0,'http://localhost:8881/activities/swimming-pool-professional-coaching/',0,'activity','',0);
INSERT INTO `wp_posts` VALUES (65,0,'2026-09-22 13:29:37','2026-09-22 13:29:37','Category: fitness-sports\nBadge: Indoor Sports','Table Tennis Academy','','publish','closed','closed','','table-tennis-academy','','','2026-09-22 13:29:37','2026-09-22 13:29:37','',0,'http://localhost:8881/activities/table-tennis-academy/',0,'activity','',0);
INSERT INTO `wp_posts` VALUES (66,0,'2026-09-22 13:29:37','2026-09-22 13:29:37','Category: fitness-sports\nBadge: Mind Sport','Chess Academy (Grandmaster Strategy)','','publish','closed','closed','','chess-academy-grandmaster-strategy','','','2026-09-22 13:29:37','2026-09-22 13:29:37','',0,'http://localhost:8881/activities/chess-academy-grandmaster-strategy/',0,'activity','',0);
INSERT INTO `wp_posts` VALUES (67,0,'2026-09-22 13:29:37','2026-09-22 13:29:37','Category: health-therapy\nBadge: Confidential','Holistic Psychological Counselling','','publish','closed','closed','','holistic-psychological-counselling','','','2026-09-22 13:29:37','2026-09-22 13:29:37','',0,'http://localhost:8881/activities/holistic-psychological-counselling/',0,'activity','',0);
INSERT INTO `wp_posts` VALUES (68,0,'2026-09-22 13:29:37','2026-09-22 13:29:37','Category: health-therapy\nBadge: Natural Healing','Acupressure & Colour Therapy','','publish','closed','closed','','acupressure-colour-therapy','','','2026-09-22 13:29:37','2026-09-22 13:29:37','',0,'http://localhost:8881/activities/acupressure-colour-therapy/',0,'activity','',0);
INSERT INTO `wp_posts` VALUES (69,0,'2026-09-22 13:29:37','2026-09-22 13:29:37','Category: health-therapy\nBadge: Clinical Care','Yoga Therapy & Naturopathy Desk','','publish','closed','closed','','yoga-therapy-naturopathy-desk','','','2026-09-22 13:29:37','2026-09-22 13:29:37','',0,'http://localhost:8881/activities/yoga-therapy-naturopathy-desk/',0,'activity','',0);
INSERT INTO `wp_posts` VALUES (70,0,'2026-09-22 13:29:37','2026-09-22 13:29:37','Category: health-therapy\nBadge: Restorative','Therapeutic Ayurvedic Body Massage','','publish','closed','closed','','therapeutic-ayurvedic-body-massage','','','2026-09-22 13:29:37','2026-09-22 13:29:37','',0,'http://localhost:8881/activities/therapeutic-ayurvedic-body-massage/',0,'activity','',0);
INSERT INTO `wp_posts` VALUES (71,0,'2026-09-22 13:29:37','2026-09-22 13:29:37','Category: knowledge-culture\nBadge: Language','Kannada Coaching (Spoken & Written)','','publish','closed','closed','','kannada-coaching-spoken-written','','','2026-09-22 13:29:37','2026-09-22 13:29:37','',0,'http://localhost:8881/activities/kannada-coaching-spoken-written/',0,'activity','',0);
INSERT INTO `wp_posts` VALUES (72,0,'2026-09-22 13:29:37','2026-09-22 13:29:37','Category: knowledge-culture\nBadge: Civilizational Heritage','Vishwa Samskrama Cultural Classes','','publish','closed','closed','','vishwa-samskrama-cultural-classes','','','2026-09-22 13:29:37','2026-09-22 13:29:37','',0,'http://localhost:8881/activities/vishwa-samskrama-cultural-classes/',0,'activity','',0);
INSERT INTO `wp_posts` VALUES (73,0,'2026-09-22 13:29:37','2026-09-22 13:29:37','Category: knowledge-culture\nBadge: Wisdom Circle','Bhagavadgita Study Circles','','publish','closed','closed','','bhagavadgita-study-circles','','','2026-09-22 13:29:37','2026-09-22 13:29:37','',0,'http://localhost:8881/activities/bhagavadgita-study-circles/',0,'activity','',0);
INSERT INTO `wp_posts` VALUES (74,0,'2026-09-22 13:29:37','2026-09-22 13:29:37','Category: knowledge-culture\nBadge: Artistry','Calligraphy & Vedic Arts','','publish','closed','closed','','calligraphy-vedic-arts','','','2026-09-22 13:29:37','2026-09-22 13:29:37','',0,'http://localhost:8881/activities/calligraphy-vedic-arts/',0,'activity','',0);
INSERT INTO `wp_posts` VALUES (75,0,'2026-09-22 14:37:04','2026-09-22 14:37:04','','About Us','','publish','closed','closed','','about-us','','','2026-09-22 14:37:04','2026-09-22 14:37:04','',0,'http://localhost:8881/about-us/',0,'page','',0);
INSERT INTO `wp_posts` VALUES (76,0,'2026-09-22 14:37:04','2026-09-22 14:37:04','','Activities','','publish','closed','closed','','activities','','','2026-09-22 14:37:04','2026-09-22 14:37:04','',0,'http://localhost:8881/activities/',0,'page','',0);
INSERT INTO `wp_posts` VALUES (77,0,'2026-09-22 14:37:04','2026-09-22 14:37:04','','Centers','','publish','closed','closed','','centers','','','2026-09-22 14:37:04','2026-09-22 14:37:04','',0,'http://localhost:8881/centers/',0,'page','',0);
INSERT INTO `wp_posts` VALUES (78,0,'2026-09-22 14:37:04','2026-09-22 14:37:04','','Events','','publish','closed','closed','','events','','','2026-09-22 14:37:04','2026-09-22 14:37:04','',0,'http://localhost:8881/events/',0,'page','',0);
INSERT INTO `wp_posts` VALUES (79,0,'2026-09-22 14:37:04','2026-09-22 14:37:04','','Gallery','','publish','closed','closed','','gallery','','','2026-09-22 14:37:04','2026-09-22 14:37:04','',0,'http://localhost:8881/gallery/',0,'page','',0);
INSERT INTO `wp_posts` VALUES (80,0,'2026-09-22 14:37:04','2026-09-22 14:37:04','','Contact Us','','publish','closed','closed','','contact-us','','','2026-09-22 14:37:04','2026-09-22 14:37:04','',0,'http://localhost:8881/contact-us/',0,'page','',0);
INSERT INTO `wp_posts` VALUES (82,0,'2026-09-24 04:58:39','2026-09-24 04:58:39','Over 5,000 yoga practitioners gathered at dawn for synchronized Surya Namaskars, Common Yoga Protocol demonstrations, and guided collective meditation.','International Yoga Day 2026 Celebration','','publish','closed','closed','','international-yoga-day-2026-celebration','','','2026-09-24 04:58:39','2026-09-24 04:58:39','',0,'http://localhost:8881/gallery-album/international-yoga-day-2026-celebration/',0,'gallery_album','',0);
INSERT INTO `wp_posts` VALUES (83,0,'2026-09-24 04:58:39','2026-09-24 04:58:39','A joyful 8-day summer intensive nurturing flexibility, concentration, memory techniques, sloka chanting, and Vedic storytelling for 250+ youngsters.','Children’s Annual Yoga & Creativity Camp','','publish','closed','closed','','childrens-annual-yoga-creativity-camp','','','2026-09-24 04:58:39','2026-09-24 04:58:39','',0,'http://localhost:8881/gallery-album/childrens-annual-yoga-creativity-camp/',0,'gallery_album','',0);
INSERT INTO `wp_posts` VALUES (84,0,'2026-09-24 04:58:39','2026-09-24 04:58:39','Individualized clinical therapeutic protocols addressing spinal disorders, hypertension, metabolic balance, and respiratory enhancement with Ayurvedic doctors.','Yoga Therapy & Clinical Healing Intensive','','publish','closed','closed','','yoga-therapy-clinical-healing-intensive','','','2026-09-24 04:58:39','2026-09-24 04:58:39','',0,'http://localhost:8881/gallery-album/yoga-therapy-clinical-healing-intensive/',0,'gallery_album','',0);
INSERT INTO `wp_posts` VALUES (85,0,'2026-09-24 04:58:39','2026-09-24 04:58:39','Commemorating Swami Vivekananda with an energetic 108 Surya Namaskar challenge, martial arts demonstrations, and leadership workshops attended by 1,200+ college youth.','National Youth Day & Surya Namaskar Yajna','','publish','closed','closed','','national-youth-day-surya-namaskar-yajna','','','2026-09-24 04:58:39','2026-09-24 04:58:39','',0,'http://localhost:8881/gallery-album/national-youth-day-surya-namaskar-yajna/',0,'gallery_album','',0);
INSERT INTO `wp_posts` VALUES (86,0,'2026-09-24 04:58:39','2026-09-24 04:58:39','Taking the gift of yoga, nutrition counseling, and health screenings to underprivileged neighborhoods across Bengaluru, impacting over 3,000 residents.','Community Wellness & Slum Outreach Drive','','publish','closed','closed','','community-wellness-slum-outreach-drive','','','2026-09-24 04:58:39','2026-09-24 04:58:39','',0,'http://localhost:8881/gallery-album/community-wellness-slum-outreach-drive/',0,'gallery_album','',0);
INSERT INTO `wp_posts` VALUES (87,0,'2026-09-24 04:58:39','2026-09-24 04:58:39','An immersive evening of spiritual discourse, classical Nada Yoga recitals, deep diaphragmatic breath immersion, and reflective silence.','Pranayama, Meditation & Cultural Utsav','','publish','closed','closed','','pranayama-meditation-cultural-utsav','','','2026-09-24 04:58:39','2026-09-24 04:58:39','',0,'http://localhost:8881/gallery-album/pranayama-meditation-cultural-utsav/',0,'gallery_album','',0);
INSERT INTO `wp_posts` VALUES (88,0,'2026-09-24 04:58:39','2026-09-24 04:58:39','','Home','','publish','closed','closed','','home','','','2026-09-24 04:58:39','2026-09-24 04:58:39','',0,'http://localhost:8881/home/',0,'page','',0);
INSERT INTO `wp_posts` VALUES (101,0,'2026-09-30 15:19:34','2026-09-30 15:19:34','','dsc08484','','inherit','open','closed','','dsc08484','','','2026-09-30 15:19:34','2026-09-30 15:19:34','',74,'http://localhost:8881/wp-content/uploads/2026/09/dsc08484.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (102,0,'2026-09-30 15:19:38','2026-09-30 15:19:38','','dsc08484-1','','inherit','open','closed','','dsc08484-1','','','2026-09-30 15:19:38','2026-09-30 15:19:38','',73,'http://localhost:8881/wp-content/uploads/2026/09/dsc08484-1.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (103,0,'2026-09-30 15:19:42','2026-09-30 15:19:42','','dsc08484-2','','inherit','open','closed','','dsc08484-2','','','2026-09-30 15:19:42','2026-09-30 15:19:42','',72,'http://localhost:8881/wp-content/uploads/2026/09/dsc08484-2.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (104,0,'2026-09-30 15:19:46','2026-09-30 15:19:46','','dsc08484-3','','inherit','open','closed','','dsc08484-3','','','2026-09-30 15:19:46','2026-09-30 15:19:46','',71,'http://localhost:8881/wp-content/uploads/2026/09/dsc08484-3.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (105,0,'2026-09-30 15:19:50','2026-09-30 15:19:50','','07-04-24-summer-camp-in-rysri-yoga-centres-1-','','inherit','open','closed','','07-04-24-summer-camp-in-rysri-yoga-centres-1','','','2026-09-30 15:19:50','2026-09-30 15:19:50','',70,'http://localhost:8881/wp-content/uploads/2026/09/07-04-24-summer-camp-in-rysri-yoga-centres-1-.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (106,0,'2026-09-30 15:19:53','2026-09-30 15:19:53','','07-04-24-summer-camp-in-rysri-yoga-centres-1-1-1','','inherit','open','closed','','07-04-24-summer-camp-in-rysri-yoga-centres-1-1-1','','','2026-09-30 15:19:53','2026-09-30 15:19:53','',69,'http://localhost:8881/wp-content/uploads/2026/09/07-04-24-summer-camp-in-rysri-yoga-centres-1-1-1.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (107,0,'2026-09-30 15:19:55','2026-09-30 15:19:55','','07-04-24-summer-camp-in-rysri-yoga-centres-1-1-2','','inherit','open','closed','','07-04-24-summer-camp-in-rysri-yoga-centres-1-1-2','','','2026-09-30 15:19:55','2026-09-30 15:19:55','',68,'http://localhost:8881/wp-content/uploads/2026/09/07-04-24-summer-camp-in-rysri-yoga-centres-1-1-2.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (108,0,'2026-09-30 15:19:58','2026-09-30 15:19:58','','07-04-24-summer-camp-in-rysri-yoga-centres-1-1-3','','inherit','open','closed','','07-04-24-summer-camp-in-rysri-yoga-centres-1-1-3','','','2026-09-30 15:19:58','2026-09-30 15:19:58','',67,'http://localhost:8881/wp-content/uploads/2026/09/07-04-24-summer-camp-in-rysri-yoga-centres-1-1-3.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (109,0,'2026-09-30 15:20:01','2026-09-30 15:20:01','','21-06-24-idy-celebration-by-rysri-jayanagar-1-','','inherit','open','closed','','21-06-24-idy-celebration-by-rysri-jayanagar-1','','','2026-09-30 15:20:01','2026-09-30 15:20:01','',66,'http://localhost:8881/wp-content/uploads/2026/09/21-06-24-idy-celebration-by-rysri-jayanagar-1-.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (110,0,'2026-09-30 15:20:03','2026-09-30 15:20:03','','21-06-24-idy-celebration-by-rysri-jayanagar-1-1-1','','inherit','open','closed','','21-06-24-idy-celebration-by-rysri-jayanagar-1-1-1','','','2026-09-30 15:20:03','2026-09-30 15:20:03','',65,'http://localhost:8881/wp-content/uploads/2026/09/21-06-24-idy-celebration-by-rysri-jayanagar-1-1-1.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (111,0,'2026-09-30 15:20:05','2026-09-30 15:20:05','','21-06-24-idy-celebration-by-rysri-jayanagar-1-1-2','','inherit','open','closed','','21-06-24-idy-celebration-by-rysri-jayanagar-1-1-2','','','2026-09-30 15:20:05','2026-09-30 15:20:05','',64,'http://localhost:8881/wp-content/uploads/2026/09/21-06-24-idy-celebration-by-rysri-jayanagar-1-1-2.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (112,0,'2026-09-30 15:20:07','2026-09-30 15:20:07','','21-06-24-idy-celebration-by-rysri-jayanagar-1-1-3','','inherit','open','closed','','21-06-24-idy-celebration-by-rysri-jayanagar-1-1-3','','','2026-09-30 15:20:07','2026-09-30 15:20:07','',63,'http://localhost:8881/wp-content/uploads/2026/09/21-06-24-idy-celebration-by-rysri-jayanagar-1-1-3.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (113,0,'2026-09-30 15:20:08','2026-09-30 15:20:08','','21-06-22-idy-celebration-12-','','inherit','open','closed','','21-06-22-idy-celebration-12','','','2026-09-30 15:20:08','2026-09-30 15:20:08','',62,'http://localhost:8881/wp-content/uploads/2026/09/21-06-22-idy-celebration-12-.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (114,0,'2026-09-30 15:20:11','2026-09-30 15:20:11','','21-06-22-idy-celebration-12-1-1','','inherit','open','closed','','21-06-22-idy-celebration-12-1-1','','','2026-09-30 15:20:11','2026-09-30 15:20:11','',61,'http://localhost:8881/wp-content/uploads/2026/09/21-06-22-idy-celebration-12-1-1.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (115,0,'2026-09-30 15:20:15','2026-09-30 15:20:15','','21-06-22-idy-celebration-12-1-2','','inherit','open','closed','','21-06-22-idy-celebration-12-1-2','','','2026-09-30 15:20:15','2026-09-30 15:20:15','',60,'http://localhost:8881/wp-content/uploads/2026/09/21-06-22-idy-celebration-12-1-2.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (116,0,'2026-09-30 15:20:18','2026-09-30 15:20:18','','21-06-22-idy-celebration-12-1-3','','inherit','open','closed','','21-06-22-idy-celebration-12-1-3','','','2026-09-30 15:20:18','2026-09-30 15:20:18','',59,'http://localhost:8881/wp-content/uploads/2026/09/21-06-22-idy-celebration-12-1-3.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (117,0,'2026-09-30 15:20:21','2026-09-30 15:20:21','','05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1-','','inherit','open','closed','','05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1','','','2026-09-30 15:20:21','2026-09-30 15:20:21','',58,'http://localhost:8881/wp-content/uploads/2026/09/05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1-.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (118,0,'2026-09-30 15:20:26','2026-09-30 15:20:26','','05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1-1-1','','inherit','open','closed','','05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1-1-1','','','2026-09-30 15:20:26','2026-09-30 15:20:26','',57,'http://localhost:8881/wp-content/uploads/2026/09/05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1-1-1.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (119,0,'2026-09-30 15:20:31','2026-09-30 15:20:31','','05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1-1-2','','inherit','open','closed','','05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1-1-2','','','2026-09-30 15:20:31','2026-09-30 15:20:31','',56,'http://localhost:8881/wp-content/uploads/2026/09/05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1-1-2.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (120,0,'2026-09-30 15:20:36','2026-09-30 15:20:36','','05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1-1-3','','inherit','open','closed','','05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1-1-3','','','2026-09-30 15:20:36','2026-09-30 15:20:36','',55,'http://localhost:8881/wp-content/uploads/2026/09/05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1-1-3.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (121,0,'2026-09-30 15:20:42','2026-09-30 15:20:42','','18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1-','','inherit','open','closed','','18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1','','','2026-09-30 15:20:42','2026-09-30 15:20:42','',54,'http://localhost:8881/wp-content/uploads/2026/09/18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1-.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (122,0,'2026-09-30 15:20:46','2026-09-30 15:20:46','','18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1-1-1','','inherit','open','closed','','18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1-1-1','','','2026-09-30 15:20:46','2026-09-30 15:20:46','',53,'http://localhost:8881/wp-content/uploads/2026/09/18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1-1-1.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (123,0,'2026-09-30 15:20:51','2026-09-30 15:20:51','','18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1-1-2','','inherit','open','closed','','18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1-1-2','','','2026-09-30 15:20:51','2026-09-30 15:20:51','',52,'http://localhost:8881/wp-content/uploads/2026/09/18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1-1-2.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (124,0,'2026-09-30 15:20:55','2026-09-30 15:20:55','','18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1-1-3','','inherit','open','closed','','18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1-1-3','','','2026-09-30 15:20:55','2026-09-30 15:20:55','',51,'http://localhost:8881/wp-content/uploads/2026/09/18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1-1-3.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (125,0,'2026-09-30 15:20:59','2026-09-30 15:20:59','','18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1-','','inherit','open','closed','','18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1','','','2026-09-30 15:20:59','2026-09-30 15:20:59','',50,'http://localhost:8881/wp-content/uploads/2026/09/18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1-.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (126,0,'2026-09-30 15:21:03','2026-09-30 15:21:03','','18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1-1-1','','inherit','open','closed','','18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1-1-1','','','2026-09-30 15:21:03','2026-09-30 15:21:03','',49,'http://localhost:8881/wp-content/uploads/2026/09/18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1-1-1.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (127,0,'2026-09-30 15:21:06','2026-09-30 15:21:06','','18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1-1-2','','inherit','open','closed','','18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1-1-2','','','2026-09-30 15:21:06','2026-09-30 15:21:06','',48,'http://localhost:8881/wp-content/uploads/2026/09/18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1-1-2.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (128,0,'2026-09-30 15:21:11','2026-09-30 15:21:11','','18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1-1-3','','inherit','open','closed','','18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1-1-3','','','2026-09-30 15:21:11','2026-09-30 15:21:11','',47,'http://localhost:8881/wp-content/uploads/2026/09/18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1-1-3.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (129,0,'2026-09-30 15:21:15','2026-09-30 15:21:15','','05-01-25-kutumba-milana-rysri-jayanagar-3-','','inherit','open','closed','','05-01-25-kutumba-milana-rysri-jayanagar-3','','','2026-09-30 15:21:15','2026-09-30 15:21:15','',46,'http://localhost:8881/wp-content/uploads/2026/09/05-01-25-kutumba-milana-rysri-jayanagar-3-.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (130,0,'2026-09-30 15:21:18','2026-09-30 15:21:18','','05-01-25-kutumba-milana-rysri-jayanagar-3-1-1','','inherit','open','closed','','05-01-25-kutumba-milana-rysri-jayanagar-3-1-1','','','2026-09-30 15:21:18','2026-09-30 15:21:18','',45,'http://localhost:8881/wp-content/uploads/2026/09/05-01-25-kutumba-milana-rysri-jayanagar-3-1-1.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (131,0,'2026-09-30 15:21:22','2026-09-30 15:21:22','','05-01-25-kutumba-milana-rysri-jayanagar-3-1-2','','inherit','open','closed','','05-01-25-kutumba-milana-rysri-jayanagar-3-1-2','','','2026-09-30 15:21:22','2026-09-30 15:21:22','',44,'http://localhost:8881/wp-content/uploads/2026/09/05-01-25-kutumba-milana-rysri-jayanagar-3-1-2.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (132,0,'2026-09-30 15:21:26','2026-09-30 15:21:26','','05-01-25-kutumba-milana-rysri-jayanagar-3-1-3','','inherit','open','closed','','05-01-25-kutumba-milana-rysri-jayanagar-3-1-3','','','2026-09-30 15:21:26','2026-09-30 15:21:26','',43,'http://localhost:8881/wp-content/uploads/2026/09/05-01-25-kutumba-milana-rysri-jayanagar-3-1-3.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (167,0,'2026-10-02 13:29:35','2026-10-02 13:29:35','"Patanjali Yoga Mandira", No. 10, 9th crosss, 8th main, Palace Orchards, Near Sankey Tank, Sadashivnagr, Bengaluru-560080','Sadashivnagar','','publish','closed','closed','','sadashivnagar','','','2026-10-02 13:29:35','2026-10-02 13:29:35','',0,'http://localhost:8881/center/sadashivnagar/',0,'rs_center','',0);
INSERT INTO `wp_posts` VALUES (168,0,'2026-10-02 13:29:36','2026-10-02 13:29:36','Sri siddaramanna yogashrama trust 35,36 /1  7th  main Gayathrinagar, Bangalore  - 560021','Gayathrinagar','','publish','closed','closed','','gayathrinagar','','','2026-10-02 13:29:36','2026-10-02 13:29:36','',0,'http://localhost:8881/center/gayathrinagar/',0,'rs_center','',0);
INSERT INTO `wp_posts` VALUES (169,0,'2026-10-02 13:29:36','2026-10-02 13:29:36','#265,poornaprajna,3rd cross,11th main,rbi layout,jp nagar 7th phase','RBI Layout','','publish','closed','closed','','rbi-layout','','','2026-10-02 13:29:36','2026-10-02 13:29:36','',0,'http://localhost:8881/center/rbi-layout/',0,'rs_center','',0);
INSERT INTO `wp_posts` VALUES (170,0,'2026-10-02 13:29:36','2026-10-02 13:29:36','','KAMAKSHIPALYA','','publish','closed','closed','','kamakshipalya','','','2026-10-02 13:29:36','2026-10-02 13:29:36','',0,'http://localhost:8881/center/kamakshipalya/',0,'rs_center','',0);
INSERT INTO `wp_posts` VALUES (171,0,'2026-10-02 13:29:36','2026-10-02 13:29:36','Keshavashilpa, Kempegowda  Nagar, Bengaluru-560004','KG NAGAR','','publish','closed','closed','','kg-nagar','','','2026-10-02 13:29:36','2026-10-02 13:29:36','',0,'http://localhost:8881/center/kg-nagar/',0,'rs_center','',0);
INSERT INTO `wp_posts` VALUES (172,0,'2026-10-02 13:29:36','2026-10-02 13:29:36','Nandagokula, #19, 6th Cross, 6th Block,','Nagarbhavi','','publish','closed','closed','','nagarbhavi','','','2026-10-02 13:29:36','2026-10-02 13:29:36','',0,'http://localhost:8881/center/nagarbhavi/',0,'rs_center','',0);
INSERT INTO `wp_posts` VALUES (173,0,'2026-10-02 13:29:36','2026-10-02 13:29:36','Rashtrotthana Yogic Sciences And Research Institute 21st Cross, 20th Main, MRCR Layout, Namaste Hotel Backside Marenahalli Road Vijaynagar Bengaluru-560040','Vijaynagar','','publish','closed','closed','','vijaynagar','','','2026-10-02 13:29:36','2026-10-02 13:29:36','',0,'http://localhost:8881/center/vijaynagar/',0,'rs_center','',0);
INSERT INTO `wp_posts` VALUES (174,0,'2026-10-02 13:29:36','2026-10-02 13:29:36','#55/A, Bull Temple Road, Sunkenahalli, Near Dodda Ganesh Temple, basavangudi Bangalore 560004','Sunkenahalli','','publish','closed','closed','','sunkenahalli','','','2026-10-02 13:29:36','2026-10-02 13:29:36','',0,'http://localhost:8881/center/sunkenahalli/',0,'rs_center','',0);
INSERT INTO `wp_posts` VALUES (175,0,'2026-10-02 13:29:36','2026-10-02 13:29:36','Raghavendra matt  near aksharam Girinagar','Girinagar','','publish','closed','closed','','girinagar','','','2026-10-02 13:29:36','2026-10-02 13:29:36','',0,'http://localhost:8881/center/girinagar/',0,'rs_center','',0);
INSERT INTO `wp_posts` VALUES (176,0,'2026-10-02 13:29:36','2026-10-02 13:29:36','Raghavendra matt  near aksharam Girinagar','Aksharam','','publish','closed','closed','','aksharam','','','2026-10-02 13:29:36','2026-10-02 13:29:36','',0,'http://localhost:8881/center/aksharam/',0,'rs_center','',0);
INSERT INTO `wp_posts` VALUES (177,0,'2026-10-02 13:29:36','2026-10-02 13:29:36','Rashtrotthana Yoga Center,                                   60 Ft Road, E Block, AECS Layout,Near BBMP Ground, Kundalahalli, Bengaluru - 560037','Kundalahalli','','publish','closed','closed','','kundalahalli','','','2026-10-02 13:29:36','2026-10-02 13:29:36','',0,'http://localhost:8881/center/kundalahalli/',0,'rs_center','',0);
INSERT INTO `wp_posts` VALUES (178,0,'2026-10-02 13:29:36','2026-10-02 13:29:36','36th Cross, 10th Main Road \n(behind BSNL Telephone Exchange), \n4th Block, Jayanagar, Bengaluru, \nKarnataka 560041.','Jayanagar','','publish','closed','closed','','jayanagar','','','2026-10-02 13:29:36','2026-10-02 13:29:36','',0,'http://localhost:8881/center/jayanagar/',0,'rs_center','',0);
INSERT INTO `wp_posts` VALUES (180,1,'2026-10-04 06:58:11','2026-10-04 06:58:11','','Hero section 2','','inherit','open','closed','','hero-section-2','','','2026-10-04 06:58:11','2026-10-04 06:58:11','',0,'http://localhost:8881/wp-content/uploads/2026/10/Hero-section-2.jpeg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (182,1,'2026-10-04 06:58:53','2026-10-04 06:58:53','','Hero section 3','','inherit','open','closed','','hero-section-3','','','2026-10-04 06:58:53','2026-10-04 06:58:53','',0,'http://localhost:8881/wp-content/uploads/2026/10/Hero-section-3.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (183,1,'2026-10-04 07:02:10','2026-10-04 07:02:10','','hero section 1','','inherit','open','closed','','hero-section-1','','','2026-10-04 07:02:10','2026-10-04 07:02:10','',0,'http://localhost:8881/wp-content/uploads/2026/10/hero-section-1.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (184,1,'2026-10-04 07:02:15','2026-10-04 07:02:15','','hero section 4','','inherit','open','closed','','hero-section-4','','','2026-10-04 07:02:15','2026-10-04 07:02:15','',0,'http://localhost:8881/wp-content/uploads/2026/10/hero-section-4.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (185,1,'2026-10-04 07:20:50','2026-10-04 07:20:50','','Shri Ajith kumar (Founder)','','inherit','open','closed','','shri-ajith-kumar-founder','','','2026-10-04 07:20:50','2026-10-04 07:20:50','',0,'http://localhost:8881/wp-content/uploads/2026/10/Shri-Ajith-kumar-Founder.png',0,'attachment','image/png',0);
INSERT INTO `wp_posts` VALUES (186,1,'2026-10-04 07:39:56','2026-10-04 07:39:56','','karate','','inherit','open','closed','','karate','','','2026-10-04 07:39:56','2026-10-04 07:39:56','',0,'http://localhost:8881/wp-content/uploads/2026/10/karate.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (187,1,'2026-10-04 07:40:09','2026-10-04 07:40:09','','GYM','','inherit','open','closed','','gym','','','2026-10-04 07:40:09','2026-10-04 07:40:09','',0,'http://localhost:8881/wp-content/uploads/2026/10/GYM.webp',0,'attachment','image/webp',0);
INSERT INTO `wp_posts` VALUES (188,1,'2026-10-04 07:40:17','2026-10-04 07:40:17','','Music','','inherit','open','closed','','music','','','2026-10-04 07:40:17','2026-10-04 07:40:17','',0,'http://localhost:8881/wp-content/uploads/2026/10/Music.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (189,1,'2026-10-04 07:40:22','2026-10-04 07:40:22','','Yoga','','inherit','open','closed','','yoga','','','2026-10-04 07:40:22','2026-10-04 07:40:22','',0,'http://localhost:8881/wp-content/uploads/2026/10/Yoga.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (190,1,'2026-10-04 08:12:54','2026-10-04 08:12:54','','Basavangudi','','inherit','open','closed','','basavangudi','','','2026-10-04 08:12:54','2026-10-04 08:12:54','',0,'http://localhost:8881/wp-content/uploads/2026/10/Basavangudi.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (191,1,'2026-10-04 08:12:54','2026-10-04 08:12:54','','Gayathrinagar','','inherit','open','closed','','gayathrinagar-2','','','2026-10-04 08:12:54','2026-10-04 08:12:54','',0,'http://localhost:8881/wp-content/uploads/2026/10/Gayathrinagar.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (192,1,'2026-10-04 08:12:55','2026-10-04 08:12:55','','Girinagar','','inherit','open','closed','','girinagar-2','','','2026-10-04 08:12:55','2026-10-04 08:12:55','',0,'http://localhost:8881/wp-content/uploads/2026/10/Girinagar.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (193,1,'2026-10-04 08:12:57','2026-10-04 08:12:57','','Jayanagara','','inherit','open','closed','','jayanagara','','','2026-10-04 08:12:57','2026-10-04 08:12:57','',0,'http://localhost:8881/wp-content/uploads/2026/10/Jayanagara.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (194,1,'2026-10-04 08:12:57','2026-10-04 08:12:57','','KAMAKSHIPALYA','','inherit','open','closed','','kamakshipalya-2','','','2026-10-04 08:12:57','2026-10-04 08:12:57','',0,'http://localhost:8881/wp-content/uploads/2026/10/KAMAKSHIPALYA.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (195,1,'2026-10-04 08:12:58','2026-10-04 08:12:58','','Kempegowda Nagar','','inherit','open','closed','','kempegowda-nagar','','','2026-10-04 08:12:58','2026-10-04 08:12:58','',0,'http://localhost:8881/wp-content/uploads/2026/10/Kempegowda-Nagar.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (196,1,'2026-10-04 08:12:58','2026-10-04 08:12:58','','Kundalahalli','','inherit','open','closed','','kundalahalli-2','','','2026-10-04 08:12:58','2026-10-04 08:12:58','',0,'http://localhost:8881/wp-content/uploads/2026/10/Kundalahalli.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (197,1,'2026-10-04 08:12:59','2026-10-04 08:12:59','','nagarbhavi','','inherit','open','closed','','nagarbhavi-2','','','2026-10-04 08:12:59','2026-10-04 08:12:59','',0,'http://localhost:8881/wp-content/uploads/2026/10/nagarbhavi.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (198,1,'2026-10-04 08:12:59','2026-10-04 08:12:59','','RBI Layout','','inherit','open','closed','','rbi-layout-2','','','2026-10-04 08:12:59','2026-10-04 08:12:59','',0,'http://localhost:8881/wp-content/uploads/2026/10/RBI-Layout.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (199,1,'2026-10-04 08:13:00','2026-10-04 08:13:00','','Sadashivnagar','','inherit','open','closed','','sadashivnagar-2','','','2026-10-04 08:13:00','2026-10-04 08:13:00','',0,'http://localhost:8881/wp-content/uploads/2026/10/Sadashivnagar.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (200,1,'2026-10-04 08:13:00','2026-10-04 08:13:00','','Vijaynagar','','inherit','open','closed','','vijaynagar-2','','','2026-10-04 08:13:00','2026-10-04 08:13:00','',0,'http://localhost:8881/wp-content/uploads/2026/10/Vijaynagar.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (201,1,'2026-10-04 10:39:38','2026-10-04 10:39:38','','evolution','','inherit','open','closed','','evolution','','','2026-10-04 10:39:38','2026-10-04 10:39:38','',0,'http://localhost:8881/wp-content/uploads/2026/10/evolution.jpeg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (202,1,'2026-10-04 10:40:07','2026-10-04 10:40:07','','History','','inherit','open','closed','','history','','','2026-10-04 10:40:07','2026-10-04 10:40:07','',0,'http://localhost:8881/wp-content/uploads/2026/10/History.png',0,'attachment','image/png',0);
INSERT INTO `wp_posts` VALUES (203,1,'2026-10-04 10:40:10','2026-10-04 10:40:10','','Sri Dinesh Hegde (General Secretary)','','inherit','open','closed','','sri-dinesh-hegde-general-secretary','','','2026-10-04 10:40:10','2026-10-04 10:40:10','',0,'http://localhost:8881/wp-content/uploads/2026/10/Sri-Dinesh-Hegde-General-Secretary.png',0,'attachment','image/png',0);
INSERT INTO `wp_posts` VALUES (204,1,'2026-10-04 10:40:12','2026-10-04 10:40:12','','Sri K S Narayan (Treasurer)','','inherit','open','closed','','sri-k-s-narayan-treasurer','','','2026-10-04 10:40:12','2026-10-04 10:40:12','',0,'http://localhost:8881/wp-content/uploads/2026/10/Sri-K-S-Narayan-Treasurer.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (205,1,'2026-10-04 10:40:13','2026-10-04 10:40:13','','Sri M P Kumar (President)','','inherit','open','closed','','sri-m-p-kumar-president','','','2026-10-04 10:40:13','2026-10-04 10:40:13','',0,'http://localhost:8881/wp-content/uploads/2026/10/Sri-M-P-Kumar-President.png',0,'attachment','image/png',0);
INSERT INTO `wp_posts` VALUES (206,1,'2026-10-04 11:34:19','2026-10-04 11:34:19','','12th IDY','','inherit','open','closed','','12th-idy','','','2026-10-04 11:34:19','2026-10-04 11:34:19','',0,'http://localhost:8881/wp-content/uploads/2026/10/12th-IDY.jpeg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (207,1,'2026-10-04 11:34:22','2026-10-04 11:34:22','','Chess tournament','','inherit','open','closed','','chess-tournament','','','2026-10-04 11:34:22','2026-10-04 11:34:22','',0,'http://localhost:8881/wp-content/uploads/2026/10/Chess-tournament.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (208,1,'2026-10-04 11:34:23','2026-10-04 11:34:23','','ISRO chairman NEWS image','','inherit','open','closed','','isro-chairman-news-image','','','2026-10-04 11:34:23','2026-10-04 11:34:23','',0,'http://localhost:8881/wp-content/uploads/2026/10/ISRO-chairman-NEWS-image.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (209,1,'2026-10-04 11:34:27','2026-10-04 11:34:27','','Yoga Prashikshana','','inherit','open','closed','','yoga-prashikshana','','','2026-10-04 11:34:27','2026-10-04 11:34:27','',0,'http://localhost:8881/wp-content/uploads/2026/10/Yoga-Prashikshana.jpg',0,'attachment','image/jpeg',0);
INSERT INTO `wp_posts` VALUES (210,1,'2026-06-21 06:30:00','2026-06-21 06:30:00','<p>ಜೂನ್ 21: ರಾಷ್ಟ್ರೋತ್ಥಾನದ (ಬೆಂಗಳೂರಿನ) KG ನಗರ/ ಸುಂಕೇನಹಳ್ಳಿ, ಜಯನಗರ, ಸದಾಶಿವನಗರ, RBI ಬಡಾವಣೆ, ಕಾಮಾಕ್ಷಿಪಾಳ್ಯ, ಕೋಣನಕುಂಟೆ, ನಾಗರಭಾವಿ, ಗಾಯತ್ರಿನಗರ, ಕಲ್ಯಾಣನಗರ, ವಿಜಯನಗರ, ಕುಂದಲಹಳ್ಳಿ ಹಾಗೂ ದಾವಣಗೆರೆ ಮೊದಲಾದ 20+ ಯೋಗಕೇಂದ್ರಗಳಲ್ಲಿ ಯೋಗಾಸನ, ಪ್ರಾಣಾಯಾಮ, ಸೂರ್ಯನಮಸ್ಕಾರಗಳೊಂದಿಗೆ 12ನೇ ಅಂತಾರಾಷ್ಟ್ರೀಯ ಯೋಗ ದಿನಾಚರಣೆಯನ್ನು ಆಚರಿಸಲಾಯಿತು.</p>\n\n<p>June 21: The 12th International Day of Yoga was celebrated with Yogasana, Pranayama and Suryanamaskar at 20+ Rashtrotthana Yoga Centres, including KG Nagar/ Sunkenahalli, Jayanagar, Sadashivanagar, RBI Layout, Kamakshipalya, Konanakunte, Nagarabhavi, Gayatrinagar, Kalyan Nagar, Vijayanagar, Kundalahalli of Bengaluru and Davanagere.</p>\n\n<h4 style="margin: 1.25rem 0 .75rem; color: #542019; font-weight: 700; font-size: 1.1rem;">ಉಪಸ್ಥಿತರಿದ್ದ ಗಣ್ಯಮಾನ್ಯರು:</h4>\n<ul class="rs-dignitaries-list" style="margin: 0; padding-left: 1.2rem; display: flex; flex-direction: column; gap: .5rem; color: #554841; font-size: .94rem; line-height: 1.6;">\n    <li><strong>KG ನಗರ/ ಸುಂಕೇನಹಳ್ಳಿ</strong> – ಡಾ. ಎಸ್. ಸೋಮನಾಥ್, ನಿಕಟಪೂರ್ವ ಅಧ್ಯಕ್ಷರು, ISRO; ಕುಲಾಧಿಪತಿಗಳು, ಚಾಣಕ್ಯ ವಿಶ್ವವಿದ್ಯಾಲಯ</li>\n    <li><strong>ಜಯನಗರ</strong> – ಡಾ. ಬಿ. ಎನ್. ಗಂಗಾಧರ್ (ಪದ್ಮಶ್ರೀ-2020), ಮನೋವೈದ್ಯರು ಹಾಗೂ ಮಾಜಿ ನಿರ್ದೇಶಕರು, NIMHANS</li>\n    <li><strong>ಗಾಯತ್ರಿನಗರ/ ಸದಾಶಿವನಗರ</strong> – ಶ್ರೀಮತಿ ಅಶ್ವಿನಿ ಪುನೀತ್ ರಾಜಕುಮಾರ್, ಚಲನಚಿತ್ರ ನಿರ್ಮಾಪಕರು ಹಾಗೂ ಡಾ. ಕರುಣಾಕರ ರೈ, ಸಾಮಾಜಿಕ ಕಾರ್ಯಕರ್ತರು</li>\n    <li><strong>ಕಾಮಾಕ್ಷಿಪಾಳ್ಯ</strong> – ಶ್ರೀ ಪುನೀತ್ ರಾಜ್, ಸಾಮಾಜಿಕ ಕಾರ್ಯಕರ್ತರು</li>\n    <li><strong>ಕುಂದಲಹಳ್ಳಿ</strong> – ಶ್ರೀ ರವೀಂದ್ರ ಮಲ್ಯ, ಸಾಮಾಜಿಕ ಕಾರ್ಯಕರ್ತರು</li>\n    <li><strong>ವಿಜಯನಗರ</strong> – ಡಾ. ಶ್ರೀಹರಿ ಶರ್ಮಾ, ಪ್ರೊಫೆಸರ್, ದಯಾನಂದ ಸಾಗರ ವಿಶ್ವವಿದ್ಯಾಲಯ</li>\n    <li><strong>ನಾಗರಭಾವಿ</strong> – ಶ್ರೀಮತಿ ವಂದನಾ ಶಾಸ್ತ್ರಿ ಸಾಮಾಜಿಕ ಕಾರ್ಯಕರ್ತರು</li>\n    <li><strong>ಕೋಣನಕುಂಟೆ</strong> – ಶ್ರೀ ಎನ್. ವಿ. ರಘುರಾಮ್, ಅಧ್ಯಕ್ಷರು, ಯೋಗ ಭಾರತಿ</li>\n    <li><strong>RBI ಬಡಾವಣೆ</strong> – ಪಂಡಿತ್ ಡಾ. ಸತೀಶ್ ಹಂಪಿಹೊಳಿ, ಕರ್ನಾಟಕ ಕಲಾಶ್ರೀ ಪ್ರಶಸ್ತಿ ಪುರಸ್ಕೃತರು, ಖ್ಯಾತ ತಬಲಾ ವಾದಕರು</li>\n    <li><strong>ಕಲ್ಯಾಣನಗರ</strong> – ಶ್ರೀ ಪದ್ಮನಾಭ ರೆಡ್ಡಿ, ಸಾಮಾಜಿಕ ಕಾರ್ಯಕರ್ತರು</li>\n    <li><strong>ದಾವಣಗೆರೆ</strong> – ಶ್ರೀಮತಿ ಅಂಬಿಕಾ ಮಾತಾಜಿ</li>\n</ul>','12th IDY','The 12th International Day of Yoga was celebrated with Yogasana, Pranayama and Suryanamaskar at 20+ Rashtrotthana Yoga Centres across Karnataka.','publish','closed','closed','','12th-idy','','','2026-06-21 06:30:00','2026-06-21 06:30:00','',0,'http://localhost:8881/?post_type=event&p=210',0,'event','',0);
INSERT INTO `wp_posts` VALUES (211,1,'2026-06-28 09:00:00','2026-06-28 09:00:00','ಬೆಂಗಳೂರು, ಜೂನ್ 28: ರಾಷ್ಟ್ರೋತ್ಥಾನ ಚೆಸ್ ಅಕಾಡೆಮಿಯ ವತಿಯಿಂದ ಬಸವನಗುಡಿ ರಾಷ್ಟ್ರೋತ್ಥಾನ ಯೋಗಕೇಂದ್ರದಲ್ಲಿ ಚೆಸ್ ಪಂದ್ಯಾವಳಿಯನ್ನು ಆಯೋಜಿಸಲಾಗಿತ್ತು. ರಾಷ್ಟ್ರೋತ್ಥಾನ ಪರಿಷತ್ನ ಖಜಾಂಚಿಗಳಾದ ಶ್ರೀ ನಾರಾಯಣ ಕೆ. ಎಸ್. ಅವರು ಪಂದ್ಯಾವಳಿಗೆ ಚಾಲನೆ ನೀಡಿದರು. U-8, U-11, U-13, U-17 ಹಾಗೂ Open Tournament, ಎಂಬ 5 ವಿಭಾಗಗಳಲ್ಲಿ ಪಂದ್ಯಾವಳಿಯನ್ನು ಆಯೋಜಿಸಲಾಗಿತ್ತು. ಧನಾತ್ಮಕ ಚಿಂತನೆಯೊಂದಿಗೆ ಮಕ್ಕಳನ್ನು ಬೆಳೆಸುವ ಕುರಿತು ಶ್ರೀಮತಿ ಸುಷ್ಮಾ ಅವರು ಉಪನ್ಯಾಸವನ್ನು ನೀಡಿದರು.','Chess tournament','ರಾಷ್ಟ್ರೋತ್ಥಾನ ಚೆಸ್ ಅಕಾಡೆಮಿಯ ವತಿಯಿಂದ ಬಸವನಗುಡಿ ರಾಷ್ಟ್ರೋತ್ಥಾನ ಯೋಗಕೇಂದ್ರದಲ್ಲಿ ಚೆಸ್ ಪಂದ್ಯಾವಳಿಯನ್ನು ಆಯೋಜಿಸಲಾಗಿತ್ತು.','publish','closed','closed','','chess-tournament','','','2026-06-28 09:00:00','2026-06-28 09:00:00','',0,'http://localhost:8881/?post_type=event&p=211',0,'event','',0);
INSERT INTO `wp_posts` VALUES (212,1,'2026-06-21 11:00:00','2026-06-21 11:00:00','ಬೆಂಗಳೂರು, ಜೂನ್ 21: ಕೇಶವಶಿಲ್ಪದಲ್ಲಿ ಆಯೋಜಿಸಲಾಗಿದ್ದ 12ನೇ ಅಂತಾರಾಷ್ಟ್ರೀಯ ಯೋಗ ದಿನಾಚರಣೆಯಲ್ಲಿ ಇಸ್ರೋದ ನಿಕಟಪೂರ್ವ ಅಧ್ಯಕ್ಷರು ಹಾಗೂ ಚಾಣಕ್ಯ ವಿಶ್ವವಿದ್ಯಾಲಯದ ಕುಲಾಧಿಪತಿಗಳಾದ ಡಾ. ಎಸ್. ಸೋಮನಾಥ್ ಅವರು ಉಪಸ್ಥಿತರಿದ್ದು, ಯೋಗಾಭ್ಯಾಸವನ್ನು ಮಾಡಿದರು. ರಾಷ್ಟ್ರೋತ್ಥಾನ ಯೋಗ ವಿಭಾಗವು ಆಯೋಜಿಸಿದ್ದ ಕಾರ್ಯಕ್ರಮದಲ್ಲಿ ರಾಷ್ಟ್ರೋತ್ಥಾನ ಪರಿಷತ್ನ ಪ್ರಧಾನ ಕಾರ್ಯದರ್ಶಿಗಳಾದ ಶ್ರೀ ನಾ. ದಿನೇಶ್ ಹೆಗ್ಡೆಯವರು ಉಪಸ್ಥಿತರಿದ್ದರು. ಕಾರ್ಯಕ್ರಮದ ಅನಂತರದಲ್ಲಿ ಉಚಿತ ಆರೋಗ್ಯ ತಪಾಸಣೆಯನ್ನೂ ಮಾಡಲಾಯಿತು.','Former ISRO Chairman, Dr. S. Somanath practised Yoga during the 12th IDY celebrations by Rashtrotthana Yoga','ಕೇಶವಶಿಲ್ಪದಲ್ಲಿ ಆಯೋಜಿಸಲಾಗಿದ್ದ 12ನೇ ಅಂತಾರಾಷ್ಟ್ರೀಯ ಯೋಗ ದಿನಾಚರಣೆಯಲ್ಲಿ ಇಸ್ರೋದ ನಿಕಟಪೂರ್ವ ಅಧ್ಯಕ್ಷರು ಹಾಗೂ ಚಾಣಕ್ಯ ವಿಶ್ವವಿದ್ಯಾಲಯದ ಕುಲಾಧಿಪತಿಗಳಾದ ಡಾ. ಎಸ್. ಸೋಮನಾಥ್ ಅವರು ಉಪಸ್ಥಿತರಿದ್ದು, ಯೋಗಾಭ್ಯಾಸವನ್ನು ಮಾಡಿದರು.','publish','closed','closed','','former-isro-chairman-dr-s-somanath-practised-yoga-during-the-12th-idy-celebrations','','','2026-06-21 11:00:00','2026-06-21 11:00:00','',0,'http://localhost:8881/?p=212',0,'post','',0);

--
-- Table structure for table `wp_ry_form_fields`
--

DROP TABLE IF EXISTS `wp_ry_form_fields`;
CREATE TABLE `wp_ry_form_fields` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` bigint(20) unsigned NOT NULL,
  `field_key` varchar(100) NOT NULL,
  `label` varchar(255) NOT NULL,
  `field_type` varchar(50) NOT NULL,
  `options` longtext DEFAULT NULL,
  `required` tinyint(1) NOT NULL DEFAULT '0',
  `sort_order` int(11) NOT NULL DEFAULT '0',
  `settings` longtext DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `form_id` (`form_id`),
  KEY `field_key` (`field_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Table structure for table `wp_ry_forms`
--

DROP TABLE IF EXISTS `wp_ry_forms`;
CREATE TABLE `wp_ry_forms` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'active',
  `created_by` bigint(20) unsigned NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Table structure for table `wp_ry_registration_answers`
--

DROP TABLE IF EXISTS `wp_ry_registration_answers`;
CREATE TABLE `wp_ry_registration_answers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `registration_id` bigint(20) unsigned NOT NULL,
  `field_key` varchar(100) NOT NULL,
  `field_value` longtext DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `registration_id` (`registration_id`),
  KEY `field_key` (`field_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Table structure for table `wp_ry_registrations`
--

DROP TABLE IF EXISTS `wp_ry_registrations`;
CREATE TABLE `wp_ry_registrations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `registration_uuid` varchar(64) NOT NULL,
  `form_id` bigint(20) unsigned NOT NULL,
  `activity_id` bigint(20) unsigned DEFAULT NULL,
  `event_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'pending',
  `language` varchar(10) NOT NULL DEFAULT 'en',
  `source` varchar(50) NOT NULL DEFAULT 'web',
  `submitted_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `confirmed_at` datetime DEFAULT NULL,
  `cancelled_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `registration_uuid` (`registration_uuid`),
  KEY `form_id` (`form_id`),
  KEY `activity_id` (`activity_id`),
  KEY `event_id` (`event_id`),
  KEY `status` (`status`),
  KEY `email` (`email`),
  KEY `phone` (`phone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Table structure for table `wp_term_relationships`
--

DROP TABLE IF EXISTS `wp_term_relationships`;
CREATE TABLE `wp_term_relationships` (
  `object_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `term_taxonomy_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `term_order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`object_id`, `term_taxonomy_id`),
  KEY `term_taxonomy_id` (`term_taxonomy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `wp_term_relationships`
--

INSERT INTO `wp_term_relationships` VALUES (43,3,0);
INSERT INTO `wp_term_relationships` VALUES (44,3,0);
INSERT INTO `wp_term_relationships` VALUES (45,3,0);
INSERT INTO `wp_term_relationships` VALUES (46,3,0);
INSERT INTO `wp_term_relationships` VALUES (47,4,0);
INSERT INTO `wp_term_relationships` VALUES (48,4,0);
INSERT INTO `wp_term_relationships` VALUES (49,4,0);
INSERT INTO `wp_term_relationships` VALUES (50,4,0);
INSERT INTO `wp_term_relationships` VALUES (51,5,0);
INSERT INTO `wp_term_relationships` VALUES (52,5,0);
INSERT INTO `wp_term_relationships` VALUES (53,5,0);
INSERT INTO `wp_term_relationships` VALUES (54,5,0);
INSERT INTO `wp_term_relationships` VALUES (55,6,0);
INSERT INTO `wp_term_relationships` VALUES (56,6,0);
INSERT INTO `wp_term_relationships` VALUES (57,6,0);
INSERT INTO `wp_term_relationships` VALUES (58,6,0);
INSERT INTO `wp_term_relationships` VALUES (59,7,0);
INSERT INTO `wp_term_relationships` VALUES (60,7,0);
INSERT INTO `wp_term_relationships` VALUES (61,7,0);
INSERT INTO `wp_term_relationships` VALUES (62,7,0);
INSERT INTO `wp_term_relationships` VALUES (63,8,0);
INSERT INTO `wp_term_relationships` VALUES (64,8,0);
INSERT INTO `wp_term_relationships` VALUES (65,8,0);
INSERT INTO `wp_term_relationships` VALUES (66,8,0);
INSERT INTO `wp_term_relationships` VALUES (67,9,0);
INSERT INTO `wp_term_relationships` VALUES (68,9,0);
INSERT INTO `wp_term_relationships` VALUES (69,9,0);
INSERT INTO `wp_term_relationships` VALUES (70,9,0);
INSERT INTO `wp_term_relationships` VALUES (71,10,0);
INSERT INTO `wp_term_relationships` VALUES (72,10,0);
INSERT INTO `wp_term_relationships` VALUES (73,10,0);
INSERT INTO `wp_term_relationships` VALUES (74,10,0);
INSERT INTO `wp_term_relationships` VALUES (212,2,0);

--
-- Table structure for table `wp_term_taxonomy`
--

DROP TABLE IF EXISTS `wp_term_taxonomy`;
CREATE TABLE `wp_term_taxonomy` (
  `term_taxonomy_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `term_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `taxonomy` varchar(32) NOT NULL DEFAULT '',
  `description` longtext NOT NULL,
  `parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `count` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`term_taxonomy_id`),
  UNIQUE KEY `term_id_taxonomy` (`term_id`, `taxonomy`),
  KEY `taxonomy` (`taxonomy`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `wp_term_taxonomy`
--

INSERT INTO `wp_term_taxonomy` VALUES (1,1,'category','',0,1);
INSERT INTO `wp_term_taxonomy` VALUES (2,2,'category','',0,6);
INSERT INTO `wp_term_taxonomy` VALUES (3,3,'activity_category','',0,4);
INSERT INTO `wp_term_taxonomy` VALUES (4,4,'activity_category','',0,4);
INSERT INTO `wp_term_taxonomy` VALUES (5,5,'activity_category','',0,4);
INSERT INTO `wp_term_taxonomy` VALUES (6,6,'activity_category','',0,4);
INSERT INTO `wp_term_taxonomy` VALUES (7,7,'activity_category','',0,4);
INSERT INTO `wp_term_taxonomy` VALUES (8,8,'activity_category','',0,4);
INSERT INTO `wp_term_taxonomy` VALUES (9,9,'activity_category','',0,4);
INSERT INTO `wp_term_taxonomy` VALUES (10,10,'activity_category','',0,4);

--
-- Table structure for table `wp_termmeta`
--

DROP TABLE IF EXISTS `wp_termmeta`;
CREATE TABLE `wp_termmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `term_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext DEFAULT NULL,
  PRIMARY KEY (`meta_id`),
  KEY `term_id` (`term_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `wp_termmeta`
--

INSERT INTO `wp_termmeta` VALUES (1,3,'icon','?');
INSERT INTO `wp_termmeta` VALUES (2,3,'_icon','field_acat_icon');
INSERT INTO `wp_termmeta` VALUES (3,3,'tagline','Strength, Balance & Inner Peace');
INSERT INTO `wp_termmeta` VALUES (4,3,'_tagline','field_acat_tagline');
INSERT INTO `wp_termmeta` VALUES (5,3,'text','Yoga practices that build physical strength, flexibility, mental clarity, and inner calm across all age groups.');
INSERT INTO `wp_termmeta` VALUES (6,3,'_text','field_acat_text');
INSERT INTO `wp_termmeta` VALUES (7,3,'image',0);
INSERT INTO `wp_termmeta` VALUES (8,3,'_image','field_acat_image');
INSERT INTO `wp_termmeta` VALUES (9,4,'icon','?');
INSERT INTO `wp_termmeta` VALUES (10,4,'_icon','field_acat_icon');
INSERT INTO `wp_termmeta` VALUES (11,4,'tagline','Creativity, Harmony & Soul');
INSERT INTO `wp_termmeta` VALUES (12,4,'_tagline','field_acat_tagline');
INSERT INTO `wp_termmeta` VALUES (13,4,'text','Nurturing creativity and harmony through classical and contemporary vocal and instrumental music learning.');
INSERT INTO `wp_termmeta` VALUES (14,4,'_text','field_acat_text');
INSERT INTO `wp_termmeta` VALUES (15,4,'image',0);
INSERT INTO `wp_termmeta` VALUES (16,4,'_image','field_acat_image');
INSERT INTO `wp_termmeta` VALUES (17,5,'icon','?');
INSERT INTO `wp_termmeta` VALUES (18,5,'_icon','field_acat_icon');
INSERT INTO `wp_termmeta` VALUES (19,5,'tagline','Grace, Rhythm & Heritage');
INSERT INTO `wp_termmeta` VALUES (20,5,'_tagline','field_acat_tagline');
INSERT INTO `wp_termmeta` VALUES (21,5,'text','Traditional dance forms and creative movement preserving India\'s rich cultural heritage and rhythm.');
INSERT INTO `wp_termmeta` VALUES (22,5,'_text','field_acat_text');
INSERT INTO `wp_termmeta` VALUES (23,5,'image',0);
INSERT INTO `wp_termmeta` VALUES (24,5,'_image','field_acat_image');
INSERT INTO `wp_termmeta` VALUES (25,6,'icon','?');
INSERT INTO `wp_termmeta` VALUES (26,6,'_icon','field_acat_icon');
INSERT INTO `wp_termmeta` VALUES (27,6,'tagline','Discipline, Agility & Self-Defence');
INSERT INTO `wp_termmeta` VALUES (28,6,'_tagline','field_acat_tagline');
INSERT INTO `wp_termmeta` VALUES (29,6,'text','Self-defence and discipline-building through structured physical training, mental focus, and ancient techniques.');
INSERT INTO `wp_termmeta` VALUES (30,6,'_text','field_acat_text');
INSERT INTO `wp_termmeta` VALUES (31,6,'image',0);
INSERT INTO `wp_termmeta` VALUES (32,6,'_image','field_acat_image');
INSERT INTO `wp_termmeta` VALUES (33,7,'icon','?');
INSERT INTO `wp_termmeta` VALUES (34,7,'_icon','field_acat_icon');
INSERT INTO `wp_termmeta` VALUES (35,7,'tagline','Values, Character & Joyful Learning');
INSERT INTO `wp_termmeta` VALUES (36,7,'_tagline','field_acat_tagline');
INSERT INTO `wp_termmeta` VALUES (37,7,'text','Value-based education and holistic development programs designed to spark curiosity and strong character in children.');
INSERT INTO `wp_termmeta` VALUES (38,7,'_text','field_acat_text');
INSERT INTO `wp_termmeta` VALUES (39,7,'image',0);
INSERT INTO `wp_termmeta` VALUES (40,7,'_image','field_acat_image');
INSERT INTO `wp_termmeta` VALUES (41,8,'icon','?');
INSERT INTO `wp_termmeta` VALUES (42,8,'_icon','field_acat_icon');
INSERT INTO `wp_termmeta` VALUES (43,8,'tagline','Stamina, Strength & Sportsmanship');
INSERT INTO `wp_termmeta` VALUES (44,8,'_tagline','field_acat_tagline');
INSERT INTO `wp_termmeta` VALUES (45,8,'text','Build physical strength, stamina, and confidence with modern sports facilities and expert fitness coaching.');
INSERT INTO `wp_termmeta` VALUES (46,8,'_text','field_acat_text');
INSERT INTO `wp_termmeta` VALUES (47,8,'image',0);
INSERT INTO `wp_termmeta` VALUES (48,8,'_image','field_acat_image');
INSERT INTO `wp_termmeta` VALUES (49,9,'icon','?');
INSERT INTO `wp_termmeta` VALUES (50,9,'_icon','field_acat_icon');
INSERT INTO `wp_termmeta` VALUES (51,9,'tagline','Natural Healing & Holistic Care');
INSERT INTO `wp_termmeta` VALUES (52,9,'_tagline','field_acat_tagline');
INSERT INTO `wp_termmeta` VALUES (53,9,'text','Therapeutic programs and natural healing therapies restoring physical harmony, mental peace, and vital health.');
INSERT INTO `wp_termmeta` VALUES (54,9,'_text','field_acat_text');
INSERT INTO `wp_termmeta` VALUES (55,9,'image',0);
INSERT INTO `wp_termmeta` VALUES (56,9,'_image','field_acat_image');
INSERT INTO `wp_termmeta` VALUES (57,10,'icon','?');
INSERT INTO `wp_termmeta` VALUES (58,10,'_icon','field_acat_icon');
INSERT INTO `wp_termmeta` VALUES (59,10,'tagline','Wisdom, Heritage & Lifelong Learning');
INSERT INTO `wp_termmeta` VALUES (60,10,'_tagline','field_acat_tagline');
INSERT INTO `wp_termmeta` VALUES (61,10,'text','Inspiring programs celebrating timeless wisdom, regional languages, Indian philosophy, and cultural values.');
INSERT INTO `wp_termmeta` VALUES (62,10,'_text','field_acat_text');
INSERT INTO `wp_termmeta` VALUES (63,10,'image',0);
INSERT INTO `wp_termmeta` VALUES (64,10,'_image','field_acat_image');
INSERT INTO `wp_termmeta` VALUES (65,3,'image_url','http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/05-01-25-kutumba-milana-rysri-jayanagar-3-.jpg');
INSERT INTO `wp_termmeta` VALUES (66,4,'image_url','http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/18-01-25-suggi-sambhrama-kolata-in-rysri-kg-nagar-1-.jpg');
INSERT INTO `wp_termmeta` VALUES (67,5,'image_url','http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/18-02-23-cultural-heritage-tour-for-rysri-yoga-practitioners-1-.jpg');
INSERT INTO `wp_termmeta` VALUES (68,6,'image_url','http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/05-01-25-gou-puja-sambhrama-rysri-yoga-jayanagar-1-.jpg');
INSERT INTO `wp_termmeta` VALUES (69,7,'image_url','http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/21-06-22-idy-celebration-12-.jpg');
INSERT INTO `wp_termmeta` VALUES (70,8,'image_url','http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/21-06-24-idy-celebration-by-rysri-jayanagar-1-.jpg');
INSERT INTO `wp_termmeta` VALUES (71,9,'image_url','http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/07-04-24-summer-camp-in-rysri-yoga-centres-1-.jpg');
INSERT INTO `wp_termmeta` VALUES (72,10,'image_url','http://localhost:8881/wp-content/themes/rashtrotthana/assets/images/client/dsc08484.jpg');

--
-- Table structure for table `wp_terms`
--

DROP TABLE IF EXISTS `wp_terms`;
CREATE TABLE `wp_terms` (
  `term_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL DEFAULT '',
  `slug` varchar(200) NOT NULL DEFAULT '',
  `term_group` bigint(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`term_id`),
  KEY `slug` (`slug`(191)),
  KEY `name` (`name`(191))
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `wp_terms`
--

INSERT INTO `wp_terms` VALUES (1,'Uncategorized','uncategorized',0);
INSERT INTO `wp_terms` VALUES (2,'News','news',0);
INSERT INTO `wp_terms` VALUES (3,'Yoga &amp; Wellness','yoga-wellness',0);
INSERT INTO `wp_terms` VALUES (4,'Arts &amp; Music','arts-music',0);
INSERT INTO `wp_terms` VALUES (5,'Dance','dance',0);
INSERT INTO `wp_terms` VALUES (6,'Martial Arts','martial-arts',0);
INSERT INTO `wp_terms` VALUES (7,'Children Programs','children-programs',0);
INSERT INTO `wp_terms` VALUES (8,'Fitness &amp; Sports','fitness-sports',0);
INSERT INTO `wp_terms` VALUES (9,'Health &amp; Therapy','health-therapy',0);
INSERT INTO `wp_terms` VALUES (10,'Knowledge &amp; Culture','knowledge-culture',0);

--
-- Table structure for table `wp_usermeta`
--

DROP TABLE IF EXISTS `wp_usermeta`;
CREATE TABLE `wp_usermeta` (
  `umeta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext DEFAULT NULL,
  PRIMARY KEY (`umeta_id`),
  KEY `user_id` (`user_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `wp_usermeta`
--

INSERT INTO `wp_usermeta` VALUES (1,1,'nickname','admin');
INSERT INTO `wp_usermeta` VALUES (2,1,'first_name','');
INSERT INTO `wp_usermeta` VALUES (3,1,'last_name','');
INSERT INTO `wp_usermeta` VALUES (4,1,'description','');
INSERT INTO `wp_usermeta` VALUES (5,1,'rich_editing','true');
INSERT INTO `wp_usermeta` VALUES (6,1,'syntax_highlighting','true');
INSERT INTO `wp_usermeta` VALUES (7,1,'infinite_scrolling','true');
INSERT INTO `wp_usermeta` VALUES (8,1,'comment_shortcuts','false');
INSERT INTO `wp_usermeta` VALUES (9,1,'admin_color','modern');
INSERT INTO `wp_usermeta` VALUES (10,1,'use_ssl',0);
INSERT INTO `wp_usermeta` VALUES (11,1,'show_admin_bar_front','true');
INSERT INTO `wp_usermeta` VALUES (12,1,'locale','');
INSERT INTO `wp_usermeta` VALUES (13,1,'wp_capabilities','a:1:{s:13:"administrator";b:1;}');
INSERT INTO `wp_usermeta` VALUES (14,1,'wp_user_level',10);
INSERT INTO `wp_usermeta` VALUES (15,1,'dismissed_wp_pointers','');
INSERT INTO `wp_usermeta` VALUES (16,1,'show_welcome_panel',1);
INSERT INTO `wp_usermeta` VALUES (17,1,'session_tokens','a:4:{s:64:"7a7cc8472841eba1ea30308b92bda1a4c606b7ba44c909b35ff58b8076ad365c";a:4:{s:10:"expiration";i:1791298024;s:2:"ip";s:9:"127.0.0.1";s:2:"ua";s:111:"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36";s:5:"login";i:1790088424;}s:64:"e570ab567f7b69ac6bbb06ab93e66317bb05a18b966b344ad03e4a876ab604d1";a:4:{s:10:"expiration";i:1791228980;s:2:"ip";s:9:"127.0.0.1";s:2:"ua";s:111:"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36";s:5:"login";i:1791056180;}s:64:"b22bc53c31ce95b7cbcd5f5eeb601dd564eefb13556e50f27be497c1dba61c08";a:4:{s:10:"expiration";i:1791269544;s:2:"ip";s:9:"127.0.0.1";s:2:"ua";s:111:"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36";s:5:"login";i:1791096744;}s:64:"2bdfa6ec8eca51d8704537daec4b6f040bccb589262d7bdf911f353d7adec1b7";a:4:{s:10:"expiration";i:1791283060;s:2:"ip";s:9:"127.0.0.1";s:2:"ua";s:111:"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36";s:5:"login";i:1791110260;}}');
INSERT INTO `wp_usermeta` VALUES (18,1,'wp_dashboard_quick_press_last_post_id',179);
INSERT INTO `wp_usermeta` VALUES (19,1,'community-events-location','a:1:{s:2:"ip";s:9:"127.0.0.0";}');
INSERT INTO `wp_usermeta` VALUES (20,1,'wp_user-settings','uploader=1');
INSERT INTO `wp_usermeta` VALUES (21,1,'wp_user-settings-time',1791097093);

--
-- Table structure for table `wp_users`
--

DROP TABLE IF EXISTS `wp_users`;
CREATE TABLE `wp_users` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_login` varchar(60) NOT NULL DEFAULT '',
  `user_pass` varchar(255) NOT NULL DEFAULT '',
  `user_nicename` varchar(50) NOT NULL DEFAULT '',
  `user_email` varchar(100) NOT NULL DEFAULT '',
  `user_url` varchar(100) NOT NULL DEFAULT '',
  `user_registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_activation_key` varchar(255) NOT NULL DEFAULT '',
  `user_status` int(11) NOT NULL DEFAULT '0',
  `display_name` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`),
  KEY `user_login_key` (`user_login`),
  KEY `user_nicename` (`user_nicename`),
  KEY `user_email` (`user_email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `wp_users`
--

INSERT INTO `wp_users` VALUES (1,'admin','$wp$2y$12$454Rdyfugxc31eep9ljyU.4FnRzWh8sNz.ofMnsXtGDuJlrZ7uMXW','admin','admin@localhost.com','http://localhost:8881','2026-08-28 14:57:36','',0,'admin');

-- Dump completed on 2026-10-04T16:06:14+00:00