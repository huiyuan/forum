DROP TABLE IF EXISTS posts;
DROP TABLE IF EXISTS topics;
DROP TABLE IF EXISTS forums;
DROP TABLE IF EXISTS categories;

CREATE TABLE categories (
   category_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
   category_name VARCHAR(255) NOT NULL,
   display_order INT(10) UNSIGNED NOT NULL DEFAULT 0,
   PRIMARY KEY(category_id)) ENGINE=InnoDB CHARSET=UTF8;
INSERT INTO categories VALUES 
(1, "Widgets", 0),
(2, "Gizmos", 1),
(3, "Doodads", 2),
(4, "Thingamajigs", 3);

CREATE TABLE forums (
   forum_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
   forum_name VARCHAR(200) NOT NULL DEFAULT 'New forum',
   forum_description TEXT,
   num_topics INT(10) UNSIGNED NOT NULL DEFAULT 0,
   num_posts INT(10) UNSIGNED NOT NULL DEFAULT 0,
   display_order INT(10) UNSIGNED NOT NULL DEFAULT 0,
   category_id INT(10) UNSIGNED NOT NULL,
   PRIMARY KEY(forum_id),
   FOREIGN KEY(category_id) REFERENCES categories(category_id)) ENGINE=InnoDB CHARSET=UTF8;
INSERT INTO forums VALUES 
(1, "Simple Widget", "Talk about our Simple Widget line of products.", 0, 0, 0, 1),
(2, "Advanced Widget", "Receive support for all your questions about our Advanced Widgets.", 2, 2, 1, 1),
(3, "Super Deluxe Widget 5000", "Get premium support for our high-end widget.", 1, 3, 2, 1),
(4, "Basic Gizmo", "It's a basic gizmo. Seriously, you get what you pay for.", 0, 0, 0, 2),
(5, "Gizmo Replacement Program", "Ask questions about our Voluntary Gizmo Recall Program.", 0, 0, 1, 2),
(6, "Advanced Gizmos", "Chat with others about your advanced gizmo needs.", 0, 0, 2, 2),
(7, "Other Gizmo Questions", "For all your gizmo related questions that don't fit elsewhere.", 0, 0, 3, 2),
(8, "Beginner Doodads", "Just your average, run-of-the-mill doodad.", 0, 0, 0, 3),
(9, "Expert Doodads", "Not for the faint of heart.", 0, 0, 1, 3),
(10, "Thingamajig Discussion", "Even we're not really sure what these things are!", 0, 0, 0, 4);

CREATE TABLE topics (
   topic_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
   subject VARCHAR(255) NOT NULL,
   author VARCHAR(200) NOT NULL DEFAULT 'New User',
   num_replies INT(10) UNSIGNED NOT NULL DEFAULT 0,
   last_poster VARCHAR(200) NOT NULL,
   last_post_time DATETIME,
   forum_id INT(10) UNSIGNED NOT NULL,
   PRIMARY KEY(topic_id),
   FOREIGN KEY(forum_id) REFERENCES forums(forum_id)) ENGINE=InnoDB CHARSET=UTF8;

INSERT INTO topics VALUES 
(1, "Requesting a refund", "Wile E. Coyote", 0, "Wile E. Coyote", "2011-12-25 10:00:00", 2),
(2, "Does it run Linux?", "Linus Torvalds", 0, "Linus Torvalds", "2011-12-25 10:15:00", 2),
(3, "Broken widget?", "Mark Zuckerberg", 2, "Mark Zuckerberg", "2011-12-25 10:00:00", 3);

CREATE TABLE posts (
   post_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
   author VARCHAR(200),
   author_id BIGINT UNSIGNED,
   posted_time DATETIME,
   contents TEXT,
   topic_id INT(10) UNSIGNED NOT NULL DEFAULT 0,
   PRIMARY KEY(post_id),
   FOREIGN KEY(topic_id) REFERENCES topics(topic_id)) ENGINE=InnoDB CHARSET=UTF8;
INSERT INTO posts VALUES 
(1, "Wile E. Coyote", 16161109309, "2011-12-25 10:00:00", "Yeah, uh, I bought a giant lifesize slingshot from you...and it just slammed me into a mountain.

I've been a customer here for years. Can I at least get a store credit or something?", 1),
(2, "Linus Torvalds", 47144560930, "2011-12-25 10:15:00", "See topic.", 2),
(3, "Mark Zuckerberg", 4, "2011-12-25 10:00:00", "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.", 3),
(4, "Andy Sandberg", 113556855362577, "2011-12-25 15:43:22", "Hey, this guy is an imposter! I'm the real Mark Zuckerberg!", 3),
(5, "Mark Zuckerberg", 4, "2011-12-26 18:15:22", "Go away, dude. It's just lame.", 3);
