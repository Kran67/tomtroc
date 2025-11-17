SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `tomtroc` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `tomtroc`;

DROP TABLE IF EXISTS `book`;
CREATE TABLE `book` (
  `id` varchar(36) NOT NULL,
  `user_id` varchar(36) NOT NULL,
  `title` varchar(100) NOT NULL,
  `author` varchar(30) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text,
  `status` enum('disponible','indisponible','réservé') NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `book` (`id`, `user_id`, `title`, `author`, `image`, `description`, `status`, `created_at`, `updated_at`) VALUES
('0925183b-9cea-412c-bece-8b9df775fbe0', 'a230ddb1-6760-44ce-9154-ff3b32b49808', 'Delight!', 'Justin Rossow', 'delight.jpg', 'Dans cet ouvrage, Justin Rossow invite les lecteurs à redécouvrir la vie de discipleship (suivre Jésus‑Christ) non pas comme une obligation lourde mais comme une aventure de joie mutuelle entre Dieu et l’être humain. Il explique que Dieu prend plaisir à nous avoir, à nous aimer, à se réjouir en nous — et que cet état est déjà un point de départ, non un objectif que nous devons gagner.\r\n\r\nIl présente la vie chrétienne comme marquée par des formes variées de “délice” : intellectuelle, émotionnelle, ludique, relationnelle — une vie où l’on explore, expérimente, respire, en lien avec Dieu, et non simplement “faire bien les choses”.\r\n\r\nRossow structure son message en trois grandes parties selon les données disponibles : d’abord, “L’architecture du délice”, qui examine les mots, les images et le vocabulaire biblique autour du plaisir, de la joie, de l’enchantement.', 'indisponible', '2025-11-03 00:00:00', '2025-11-03 00:00:00'),
('0d64a4c0-6d46-4f19-9a94-80e3a8ccb4f1', 'aa9680f3-b449-4156-83c4-02f6f5b25dc5', 'Hygge', 'Meik Wiking', 'hygge.jpg', 'Dans cet ouvrage, Meik Wiking explore le concept danois de hygge (prononcé « hoo-ga »), souvent traduit par « bien-être », « cocooning d’âme » ou « l’art de créer de l’intimité ». \r\nIl présente hygge comme une pratique de vie quotidienne centrée sur la simplicité, le confort, la convivialité et la pleine présence. Le livre s’appuie aussi bien sur des anecdotes personnelles que sur des études sociologiques (Wiking est directeur de Happiness Research Institute à Copenhague) pour expliquer pourquoi le Danemark figure systématiquement parmi les pays « les plus heureux ». \r\n\r\nWiking détaille plusieurs « ingrédients » concrets du hygge : l’éclairage doux (bougies, lampes d’appoint plutôt que lumière crue) pour instaurer une ambiance chaleureuse ; la qualité des moments partagés (temps avec les proches, sans distraction numérique) ; l’importance de savourer les petites choses — un bon repas, un thé chaud, un plaid douillet — et d’être pleinement présent. ', 'disponible', '2025-11-03 00:00:00', '2025-11-03 00:00:00'),
('15f61a2e-ac9b-40a4-9dc6-f7662580c0cf', 'aa9680f3-b449-4156-83c4-02f6f5b25dc5', 'Milk & honey', 'Rupi Kaur', 'milk_and_honey.jpg', '« Milk and Honey » est un recueil de poèmes et de textes en prose sur la survie. Sur l\'expérience de la violence, des abus, de l\'amour, de la perte et de la féminité.\r\n\r\nLe livre est divisé en quatre chapitres, chacun ayant une finalité différente. Il aborde une douleur différente. Il apaise un chagrin différent. « Lait et miel » emmène le lecteur à travers les moments les plus amers de la vie et y découvre la douceur, car elle est partout, pourvu qu\'on prenne la peine de la chercher.', 'disponible', '2025-11-03 00:00:00', '2025-11-03 00:00:00'),
('193d8cdb-fc43-4bb4-9e3e-81c44fc39bf6', 'e9931ee2-38e7-4f35-8e55-9206df95d6ef', 'The Kinfolk Table', 'Nathan Williams', 'the_kinkfolk_table.jpg', 'J\'ai récemment plongé dans les pages de \'The Kinfolk Table\' et j\'ai été enchanté par cette œuvre captivante. Ce livre va bien au-delà d\'une simple collection de recettes ; il célèbre l\'art de partager des moments authentiques autour de la table. \r\n\r\nLes photographies magnifiques et le ton chaleureux captivent dès le départ, transportant le lecteur dans un voyage à travers des recettes et des histoires qui mettent en avant la beauté de la simplicité et de la convivialité. \r\n\r\nChaque page est une invitation à ralentir, à savourer et à créer des souvenirs durables avec les êtres chers. \r\n\r\n\'The Kinfolk Table\' incarne parfaitement l\'esprit de la cuisine et de la camaraderie, et il est certain que ce livre trouvera une place spéciale dans le cœur de tout amoureux de la cuisine et des rencontres inspirantes.', 'disponible', '2025-11-03 00:00:00', '2025-11-03 00:00:00'),
('2dfe498c-1a37-45fa-af69-c169f7291fd7', 'e9931ee2-38e7-4f35-8e55-9206df95d6ef', 'Wabi Sabi', 'Beth Kempton', 'wabi_sabi.jpg', 'Le wabi-sabi (« wah-bi sah-bi ») est un concept fascinant de l\'esthétique japonaise qui nous invite à percevoir la beauté dans l\'imperfection, à apprécier la simplicité et à accepter la nature éphémère de toute chose. Puisant ses racines dans le zen et la voie du thé, la sagesse intemporelle du wabi-sabi est plus pertinente que jamais dans la vie moderne, alors que nous cherchons de nouvelles façons d\'aborder les défis de l\'existence et de donner un sens à notre vie au-delà du matérialisme.\r\n\r\nLe wabi-sabi est une bouffée d\'air frais dans notre monde trépidant et consumériste. Il vous invite à ralentir, à renouer avec la nature et à être plus indulgent envers vous-même. Il vous aide à simplifier votre vie et à vous concentrer sur l\'essentiel.\r\n\r\nDe l\'hommage rendu au rythme des saisons à la création d\'un foyer accueillant, de la façon de relativiser l\'échec au vieillissement avec grâce, le wabi-sabi vous apprendra à trouver plus de joie et d\'inspiration tout au long de votre vie, parfaitement imparfaite.\r\n\r\nCe livre est le guide de référence pour appliquer les principes du wabi-sabi afin de transformer tous les aspects de votre vie et de trouver le bonheur là où vous êtes.', 'disponible', '2025-11-03 00:00:00', '2025-11-03 00:00:00'),
('324e9331-1b64-4729-bbf5-c54900b2cada', '9341d8b9-dc80-4e5d-be6d-37812ebf5f29', 'Esther', 'Alabaster', 'esther.jpg', 'Bien que son intrigue paraisse d\'abord aléatoire et pleine de hasard, le livre d\'Esther nous invite à y voir une rencontre déterminante avec Dieu. Il nous encourage tous à observer et à écouter avec curiosité et attention les manifestations subtiles de la présence divine dans les moments les plus inattendus. Elles ne seront peut-être pas explicites ni telles que nous les attendrions, mais Dieu est assurément présent.\r\n\r\nL\'approche d\'Alabaster réinvente l\'expérience de lecture du livre. En intégrant des images qui éclairent les thèmes et les messages du texte, ce livre permettra au lecteur d\'aborder les Écritures d\'une manière nouvelle. Le Livre d\'Esther dans la traduction New Living Translation (NLT) est idéal pour les études bibliques, les groupes d\'étude biblique ou les moments de prière personnelle.\r\n\r\nAlabaster crée en pensant au lecteur, notamment grâce à une utilisation judicieuse de l\'espace négatif, des polices de caractères lisibles et des mises en page qui permettent une exploration réfléchie entre le texte et les images.', 'disponible', '2025-11-03 00:00:00', '2025-11-03 00:00:00'),
('3657cc20-2d20-42aa-97ac-a1475b3dce31', 'e06bdc3c-af56-42cf-8ef2-1f11c1472762', 'Company Of One', 'Paul Jarvis', 'company_of_one.jpg', 'Dans cet ouvrage, Paul Jarvis remet en question l’idée très répandue selon laquelle une entreprise doit toujours croître pour réussir. Il propose le concept de « company of one » — une entreprise construite pour rester petite, agile et alignée avec la vie de son fondateur plutôt que de devenir une grosse machine à croissance. Jarvis explique que la croissance par défaut peut entraîner complexité, perte d’autonomie, augmentation des coûts, des responsabilités et une dégradation de la qualité de vie. Il encourage à définir ce « suffisant » : un niveau d’activité, de revenus et de clients qui permet de vivre selon ses propres objectifs, et à construire l’entreprise à partir de ce point d’équilibre.\r\n\r\nLe livre développe plusieurs piliers : la résilience (capacité à s’adapter, à accepter la réalité et à rebondir), l’autonomie (être maître de son entreprise, sans dépendance excessive à des investisseurs ou à une large équipe), la vitesse (prendre des décisions rapidement, changer de cap facilement) et la simplicité (éviter les structures alourdies, automatiser intelligemment, servir un public ciblé plutôt que d’aspirer à conquérir tout le marché).', 'disponible', '2025-11-03 00:00:00', '2025-11-03 00:00:00'),
('607f0e82-a992-4e16-afaa-7253dfb052ab', 'd5cecf90-219a-476a-9d6b-8635b82fe551', 'Minimalist Graphics', 'Julia Schonlau', 'minimalist_graphics.jpg', 'Dans cet ouvrage, Julia Schonlau propose une exploration visuelle et conceptuelle du design graphique minimaliste. Le livre commence par une introduction qui retrace l’histoire, les principes et l’importance de la simplicité dans le graphisme.\r\n\r\nIl présente ensuite une collection de projets contemporains de design — identités visuelles, publications, imprimés — qui adoptent une esthétique « less is more », mettant l’accent sur des formes claires, des typographies épurées, des espaces négatifs bien pensés, et une communication visuelle immédiate et lisible.\r\n\r\nCe livre sert à la fois de source d’inspiration pour les graphistes et de référence visuelle pour comprendre comment la réduction, l’élimination de l’ornement superflu et la focalisation sur l’essentiel peuvent renforcer l’efficacité d’un message visuel. Il montre que le minimalisme graphique ne se limite pas à l’apparence, mais repose sur une philosophie de conception : chaque élément visuel doit avoir une raison d’être, et l’absence d’éléments non-essentiels permet de concentrer l’attention. Cette approche conduit à des résultats intemporels, sophistiqués, et souvent plus durables.', 'disponible', '2025-11-03 00:00:00', '2025-11-03 00:00:00'),
('716675b8-5aa6-4420-8e26-a021c72424d0', 'b1f35dd3-ae1f-4c48-abfd-381498920f1c', 'The Two Towers', 'J.R.R Tolkien', 'the_two_towers.jpg', 'The Two Towers (Les Deux Tours), deuxième tome du Seigneur des Anneaux de J.R.R. Tolkien, poursuit la quête de la Communauté après sa dispersion à la fin de La Communauté de l’Anneau. Le roman est divisé en deux grandes parties. La première suit Aragorn, Legolas et Gimli, qui partent à la recherche de Merry et Pippin, capturés par des orques. Leur poursuite les conduit au Rohan, royaume des cavaliers dirigé par le roi Théoden, manipulé par le traître Gríma Langue-de-Serpent, agent du mage corrompu Saroumane. Pendant ce temps, Merry et Pippin s’échappent et trouvent refuge chez Sylvebarbe, un Ent, qui mène les siens à l’assaut d’Isengard, la forteresse de Saroumane, détruisant ainsi son pouvoir.\r\n\r\nLa seconde partie se concentre sur Frodon et Sam, qui continuent seuls leur périple vers le Mordor pour détruire l’Anneau unique. Ils capturent Gollum, l’ancien porteur de l’Anneau, et le forcent à les guider à travers les terres hostiles. Gollum, déchiré entre son attachement à l’Anneau et son désir de rédemption, les conduit à travers les marais des Morts jusqu’aux portes du Mordor, puis leur propose un autre chemin secret. Mais sa duplicité se révèle lorsqu’il les mène vers Arachné, une araignée monstrueuse. Sam parvient à sauver Frodon in extremis, croyant son ami mort, et prend la décision de poursuivre la mission seul.', 'disponible', '2025-11-03 00:00:00', '2025-11-03 00:00:00'),
('9bf18bce-12f9-4111-8125-95321d6cca3a', 'b29ef0d4-c270-4e58-a2f0-ef68f5ae4e81', 'The Subtle Art Of...', 'Mark Manson', 'the_subtle_art_of.jpg', 'Dans cet ouvrage, Mark Manson remet en question les codes classiques du développement personnel — l’idée que pour être heureux il faut toujours viser plus, être plus positif, accumuler plus de succès. Il affirme que cette recherche incessante du « plus » peut en fait nous éloigner d’une vie satisfaisante.\r\n\r\nIl propose de renverser la logique : on ne peut pas ne rien « donner de foutre » (c’est‑à‑dire ne rien se soucier), mais il faut choisir avec discernement ce à quoi on décide de donner de l’importance. Cela revient à fixer ses propres valeurs et s’y tenir — plutôt que de se laisser happer par toutes les attentes externes.', 'disponible', '2025-11-03 00:00:00', '2025-11-03 00:00:00'),
('aaf32236-0e88-44b3-bd8d-066805450b70', 'a5cf98ea-b946-4445-ae26-8bb8450895b4', 'A Book Full Of Hope', 'Rupi Kaur', 'a_book_full_of_hope.jpg', 'Aucune description', 'disponible', '2025-11-03 00:00:00', '2025-11-03 00:00:00'),
('b1094163-7e64-4ac9-9aa6-da46fd43530a', 'ba578dd7-de7f-4729-a197-f5d06a61fe81', 'Psalms', 'Alabaster', 'psalms.jpg', 'L’ouvrage met en avant le texte intégral des 150 Psaumes dans des traductions modernes (par exemple la NLT ou la NTV) assorti d’un design soigné : grande taille (environ 7,5″ × 9,5″ / 19 × 24 cm), impression en pleine couleur, photographies et mise en page qui valorisent l’espace, la typographie et l’ambiance visuelle.\r\n\r\nL’intention est de permettre une expérience de lecture plus immersive et contemplative : non seulement lire les Psaumes, mais aussi les ressentir comme poésie, prière, hymne, dans un contexte visuel propice à la réflexion.\r\n\r\nLe livre présente les grandes thématiques du livre biblique des Psaumes : la louange et l’adoration (« Grandissez l’Éternel », etc.), la lamentation et la souffrance (« Pourquoi m’oublies-tu ? »), la confiance en Dieu (« L’Éternel est mon berger »), la gratitude, la recherche de sens, et la sagesse. Les versets sont accompagnés de l’espace visuel qui invite à une pause, à méditer plutôt qu’à simplement scanner. Ce format vise particulièrement ceux qui souhaitent non seulement étudier les Psaumes, mais les contempler et les vivre dans un cadre esthétique et spirituel.', 'disponible', '2025-11-03 00:00:00', '2025-11-03 00:00:00'),
('b88133d1-2bdb-48ae-bf9a-ecb7ef7ef38d', '5565c4ab-595b-42e1-8b3d-6ce0ad197650', 'Milwaukee Mission', 'Elder Cooper Low', 'milwaukee_mission.jpg', 'Aucune description', 'disponible', '2025-11-03 00:00:00', '2025-11-03 00:00:00'),
('bc0038cd-94b3-4676-8185-6c0e390fea53', 'f396f634-a58b-4ff7-b9a7-8169ccfbb5ca', 'Thinking, Fast & Slow', 'Daniel Kahneman', 'thinking_fast_and_slow.jpg', 'L’ouvrage présente une théorie centrale : la pensée humaine est gouvernée par deux systèmes mentaux distincts — le Système 1 et le Système 2. Le Système 1 fonctionne de manière rapide, automatique, intuitive ; il évalue les situations en un éclair, sans effort conscient. Le Système 2, en revanche, opère lentement, délibérément, avec concentration ; c’est lui qui entre en jeu quand l’on doit réfléchir, raisonner ou résoudre un problème complexe.\r\n\r\nKahneman montre que, parce que le Système 2 demande un effort cognitif, nous avons tendance à lui échapper et à nous fier par défaut au Système 1 — ce qui conduit régulièrement à des erreurs de jugement et à des biais cognitifs.\r\n\r\nAu fil du livre, l’auteur explore de nombreuses manifestations de ces mécanismes : heuristiques comme l’ancrage (le fait que notre jugement soit influencé par la première information rencontrée), l’accessibilité (nous surestimons la probabilité des événements qu’on se rappelle facilement), la surestimation de notre propre connaissance et la sous-estimation du rôle du hasard.', 'indisponible', '2025-11-03 00:00:00', '2025-11-03 00:00:00'),
('c869e860-0721-4a01-ad0c-f469662f43ab', '37b8fb86-9099-43e3-a396-d00891441367', 'Narnia', 'C.S Lewis', 'narnia.jpg', 'La série Les Chroniques de Narnia de C.S. Lewis est un ensemble de sept romans de fantasy publiés entre 1950 et 1956. Elle raconte les aventures d’enfants ordinaires qui découvrent et explorent le monde magique de Narnia, un royaume peuplé de créatures mythologiques, d’animaux parlants et gouverné par le lion majestueux Aslan — figure centrale symbolisant la bonté, la justice et souvent interprétée comme une métaphore du divin. Le premier publié, Le Lion, la Sorcière blanche et l’Armoire magique, introduit Lucy, Edmund, Susan et Peter Pevensie, qui trouvent une armoire menant à Narnia, alors sous le joug de la Sorcière blanche, qui y maintient un hiver éternel.\r\n\r\nAu fil des tomes, Lewis explore différents aspects de ce monde et de ses héros : la naissance de Narnia (Le Neveu du magicien), sa chute sous la tentation et la corruption (Le Prince Caspian), la quête spirituelle et le courage (L’Odyssée du Passeur d’Aurore), la loyauté et le sacrifice (Le Trône de fer et Le Fauteuil d’argent), jusqu’à la fin du monde de Narnia dans La Dernière Bataille, qui clôt la saga sur une note d’apocalypse et de renaissance.', 'indisponible', '2025-11-03 00:00:00', '2025-11-03 00:00:00'),
('dfb18e3d-9912-479e-8987-72a032997f47', '25113caf-b2cc-4513-b7b4-485fed4c8017', 'Innovation', 'Matt Ridley', 'innovation.jpg', 'L\'innovation est l\'événement majeur de notre époque, à l\'origine des progrès spectaculaires de notre niveau de vie et des bouleversements sociétaux. Au-delà des symptômes conjoncturels comme Donald Trump et le Brexit, c\'est bien l\'innovation qui façonnera le XXIe siècle. Pourtant, l\'innovation demeure un processus complexe, mal compris tant par les décideurs politiques que par les chefs d\'entreprise.\r\n\r\nMatt Ridley soutient que nous devons considérer l\'innovation comme un processus graduel, ascendant et fortuit, résultant directement de l\'habitude humaine d\'échanger, plutôt que comme un processus ordonné et descendant, se développant selon un plan. L\'innovation se distingue fondamentalement de l\'invention, car elle consiste à transformer les inventions en objets d\'utilité pratique et abordable pour tous. Elle s\'accélère dans certains secteurs et ralentit dans d\'autres. C\'est toujours un phénomène collectif et collaboratif, impliquant essais et erreurs, et non le fruit d\'un génie solitaire. Elle se produit principalement dans quelques régions du monde à un instant donné. Les économistes ne parviennent toujours pas à la modéliser correctement, mais les politiques peuvent facilement la freiner. Loin d\'être en situation de surabondance d\'innovation, nous pourrions être au bord d\'une pénurie d\'innovation.', 'indisponible', '2025-11-03 00:00:00', '2025-11-03 00:00:00');

DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
  `id` varchar(36) NOT NULL,
  `thread_id` varchar(36) NOT NULL,
  `user_id` varchar(36) NOT NULL,
  `content` text NOT NULL,
  `sent_at` datetime NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `message_thread`;
CREATE TABLE `message_thread` (
  `id` varchar(36) NOT NULL,
  `user_id` varchar(36) NOT NULL,
  `from_user_id` varchar(36) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` varchar(36) NOT NULL,
  `login` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nickname` varchar(30) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `user` (`id`, `login`, `password`, `nickname`, `avatar`, `created_at`) VALUES
('25113caf-b2cc-4513-b7b4-485fed4c8017', 'Lou&Ben50@email.com', '$2y$10$OefkCWfcDo.GKgFS2qmFYuITgzdDsrBp67p2.IrJOutZ9ptcsKCb.', 'Lou&Ben50', 'avatar1.jpg', '2024-11-01 00:00:00'),
('37b8fb86-9099-43e3-a396-d00891441367', 'AnnikaBrahms@email.com', '$2y$10$OefkCWfcDo.GKgFS2qmFYuITgzdDsrBp67p2.IrJOutZ9ptcsKCb.', 'AnnikaBrahms', 'avatar2.jpg', '2024-11-01 00:00:00'),
('5565c4ab-595b-42e1-8b3d-6ce0ad197650', 'Christiane75014@email.com', '$2y$10$OefkCWfcDo.GKgFS2qmFYuITgzdDsrBp67p2.IrJOutZ9ptcsKCb.', 'Christiane75014', 'avatar3.jpg', '2024-11-01 00:00:00'),
('9341d8b9-dc80-4e5d-be6d-37812ebf5f29', 'CamilleClubLit@email.com', '$2y$10$OefkCWfcDo.GKgFS2qmFYuITgzdDsrBp67p2.IrJOutZ9ptcsKCb.', 'CamilleClubLit', 'avatar2.jpg', '2025-11-01 00:00:00'),
('a230ddb1-6760-44ce-9154-ff3b32b49808', 'Juju1432@email.com', '$2y$10$OefkCWfcDo.GKgFS2qmFYuITgzdDsrBp67p2.IrJOutZ9ptcsKCb.', 'Juju1432', 'avatar3.jpg', '2024-11-01 00:00:00'),
('a5cf98ea-b946-4445-ae26-8bb8450895b4', 'ML95@email.com', '$2y$10$OefkCWfcDo.GKgFS2qmFYuITgzdDsrBp67p2.IrJOutZ9ptcsKCb.', 'ML95', 'avatar1.jpg', '2025-11-01 00:00:00'),
('aa9680f3-b449-4156-83c4-02f6f5b25dc5', 'Hugo1990_12@email.com', '$2y$10$OefkCWfcDo.GKgFS2qmFYuITgzdDsrBp67p2.IrJOutZ9ptcsKCb.', 'Hugo1990_12', 'avatar1.jpg', '2024-11-01 00:00:00'),
('b1f35dd3-ae1f-4c48-abfd-381498920f1c', 'Lotrfanclub67@email.com', '$2y$10$OefkCWfcDo.GKgFS2qmFYuITgzdDsrBp67p2.IrJOutZ9ptcsKCb.', 'Lotrfanclub67', 'avatar1.jpg', '2025-11-01 00:00:00'),
('b29ef0d4-c270-4e58-a2f0-ef68f5ae4e81', 'Verogo33@email.com', '$2y$10$OefkCWfcDo.GKgFS2qmFYuITgzdDsrBp67p2.IrJOutZ9ptcsKCb.', 'Verogo33', 'avatar2.jpg', '2024-11-01 00:00:00'),
('ba578dd7-de7f-4729-a197-f5d06a61fe81', 'Lolobzh@email.com', '$2y$10$OefkCWfcDo.GKgFS2qmFYuITgzdDsrBp67p2.IrJOutZ9ptcsKCb.', 'Lolobzh', 'avatar3.jpg', '2024-11-01 00:00:00'),
('d5cecf90-219a-476a-9d6b-8635b82fe551', 'Hamzalecture@email.com', '$2y$10$OefkCWfcDo.GKgFS2qmFYuITgzdDsrBp67p2.IrJOutZ9ptcsKCb.', 'Hamzalecture', 'avatar2.jpg', '2024-11-01 00:00:00'),
('e06bdc3c-af56-42cf-8ef2-1f11c1472762', 'Victoirefabr912@email.com', '$2y$10$OefkCWfcDo.GKgFS2qmFYuITgzdDsrBp67p2.IrJOutZ9ptcsKCb.', 'Victoirefabr912', 'avatar3.jpg', '2024-11-01 00:00:00'),
('e9931ee2-38e7-4f35-8e55-9206df95d6ef', 'Alexlecture@email.com', '$2y$10$OefkCWfcDo.GKgFS2qmFYuITgzdDsrBp67p2.IrJOutZ9ptcsKCb.', 'Alexlecture', 'avatar1.jpg', '2024-11-01 00:00:00'),
('ed7ce267-57a6-4c5a-b2a5-b722094553f6', 'Alice', '$2y$10$OefkCWfcDo.GKgFS2qmFYuITgzdDsrBp67p2.IrJOutZ9ptcsKCb.', 'Alice Fostre', 'avatar2.jpg', '2025-11-03 00:00:00'),
('f396f634-a58b-4ff7-b9a7-8169ccfbb5ca', 'Sas634@email.com', '$2y$10$OefkCWfcDo.GKgFS2qmFYuITgzdDsrBp67p2.IrJOutZ9ptcsKCb.', 'Sas634', 'avatar2.jpg', '2024-11-01 00:00:00');


ALTER TABLE `book`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `title` (`title`),
  ADD KEY `book_user_id_IDX` (`user_id`) USING BTREE;
ALTER TABLE `book` ADD FULLTEXT KEY `title_2` (`title`);

ALTER TABLE `message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `message_thread_id_IDX` (`thread_id`) USING BTREE,
  ADD KEY `message_user_id_IDX` (`user_id`) USING BTREE;

ALTER TABLE `message_thread`
  ADD PRIMARY KEY (`id`),
  ADD KEY `message_thread_user_id_IDX` (`user_id`) USING BTREE,
  ADD KEY `message_thread_from_user_id_IDX` (`from_user_id`) USING BTREE;

ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);


ALTER TABLE `book`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `message`
  ADD CONSTRAINT `fk_thread_id` FOREIGN KEY (`thread_id`) REFERENCES `message_thread` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `message_user_FK` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `message_thread`
  ADD CONSTRAINT `message_thread_user_FK` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `message_thread_user_FK_1` FOREIGN KEY (`from_user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
