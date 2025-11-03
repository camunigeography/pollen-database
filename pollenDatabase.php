<?php

# Class to display information in the virtualShackleton database
class pollenDatabase extends frontControllerApplication
{
	# Function to assign defaults additional to the general application defaults
	public function defaults ()
	{
		# Specify available arguments as defaults or as NULL (to represent a required argument)
		$defaults = array (
			'database'						=> 'pollen',
			'table'							=> 'pollen',
			'databaseStrictWhere'			=> true,
			'nativeTypes'					=> true,
			'administrators'				=> true,
			'div'							=> 'pollendatabase',
			'tabUlClass'					=> 'tabsflat',
			'useEditing'					=> true,
			'mediaDirectory'				=> $_SERVER['DOCUMENT_ROOT'] . $this->baseUrl . '/media/',			# Location of the images directory from the site root
			'collectionName'				=> 'the Collection',
			'copyrightOwner'				=> NULL,
			'introductionHtml'				=> false,
			'page404'						=> 'sitetech/404.html',			# Location of 404 page
			'imageGenerationStub'			=> '/images/generator',			#!# Need to remove dependency
			'width'							=> 750,		// Image width
			'maxArticlesPerPage'			=> 100,		// Max articles per page
			'helpTab'						=> true,
			'orderby'						=> array ('genus', 'family', 'species'),
			//'externalAuth'				=> true,
		);
		
		# Return the defaults
		return $defaults;
	}
	
	
	# Function assign additional actions
	public function actions ()
	{
		# Specify additional actions
		$actions = array (
			'articles' => array (
				'description' => 'List of taxa',
				'url' => 'articles/',
				'tab' => 'Database',
			),
			'clear' => array (
				'description' => 'Clear search parameters',
				'url' => 'clear.html',
				'usetab' => false,
			),
			'dump' => array (
				'description' => 'Dump of all articles',
				'url' => 'articles/dump.html',
				'usetab' => 'Articles',
				'authentication' => true,
				'administrator' => true,
			),
			'add' => array (
				'description' => 'Add new record',
				'url' => 'articles/add.html',
				'authentication' => true,
				'administrator' => true,
				'parent' => 'articles',
				'subtab' => 'Add new',
			),
			'article' => array (
				'description' => 'Record: %detail',
				'url' => 'articles/%id/',
				'parent' => 'articles',
				'subtab' => 'View',
			),
			'edit' => array (
				'description' => 'Edit record: %detail',
				'url' => 'articles/%id/edit.html',
				'usetab' => 'articles',
				'authentication' => true,
				'administrator' => true,
				'parent' => 'articles',
				'subtab' => 'Edit',
			),
			'editmaterial' => array (
				'description' => 'Edit material for record: %detail',
				'url' => 'articles/%id/editmaterial.html',
				'usetab' => 'articles',
				'authentication' => true,
				'administrator' => true,
				'parent' => 'articles',
			),
			'editmedia' => array (
				'description' => 'Edit media for record: %detail',
				'url' => 'articles/%id/editmedia.html',
				'usetab' => 'articles',
				'authentication' => true,
				'administrator' => true,
				'parent' => 'articles',
			),
			'addmaterial' => array (
				'description' => 'Add material for record: %detail',
				'url' => 'articles/%id/addmaterial.html',
				'usetab' => 'articles',
				'authentication' => true,
				'administrator' => true,
				'parent' => 'articles',
			),
			'addmaterialmedia' => array (
				'description' => 'Add media for record: %detail for material %material',
				'url' => 'articles/%id/addmaterialmedia.html',
				'usetab' => 'articles',
				'authentication' => true,
				'administrator' => true,
				'parent' => 'articles',
			),
			'addmedia' => array (
				'description' => 'Add media for record: %detail',
				'url' => 'articles/%id/addmedia.html',
				'usetab' => 'articles',
				'authentication' => true,
				'administrator' => true,
				'parent' => 'articles',
			),
			/*
			'clone' => array (
				'description' => 'Clone record: %detail to new record',
				'url' => 'articles/%id/clone.html',
				'usetab' => 'articles',
				'authentication' => true,
				'administrator' => true,
				'parent' => 'articles',
				'subtab' => 'Clone',
				'method' => 'clonerecord',
			),
			'delete' => array (
				'description' => 'Delete record: %detail',
				'url' => 'articles/%id/delete.html',
				'usetab' => 'articles',
				'authentication' => true,
				'administrator' => true,
				'parent' => 'articles',
				'subtab' => 'Delete',
			),
			*/
			'image' => array (
				'description' => 'Image: %detail',
				'usetab' => 'articles',
			),
			'copyright' => array (
				'description' => 'Copyright information',
				'usetab' => false,
			),
			/*
			'search' => array (
				'description' => 'Search for taxa',
				'tab' => 'Search for taxa',
				'url' => 'search/',
			),
			*/
			'data' => array (
				'description' => 'Edit data/lookups',
				'parent' => 'admin',
				'subtab' => 'Edit data/lookups',
				'url' => 'data/',
				'authentication' => true,
				'administrator' => true,
			),
			'links' => array (
				'description' => false,
				'url' => 'links.html',
				'tab' => 'Links',
			),
		);
		
		# Return the actions
		return $actions;
	}
	
	
	# Database structure definition
	public function databaseStructure ()
	{
		return "
			
			-- Administrators
			CREATE TABLE `administrators` (
			  `username__JOIN__people__people__reserved` varchar(191) NOT NULL COMMENT 'Username',
			  `password` varchar(255) NOT NULL COMMENT 'Password for non-Raven users',
			  `active` enum('','Yes','No') NOT NULL DEFAULT 'Yes' COMMENT 'Currently active?',
			  `userType` enum('Raven','External') NOT NULL DEFAULT 'Raven' COMMENT 'User login type',
			  `privilege` enum('Administrator','Restricted administrator') NOT NULL DEFAULT 'Administrator' COMMENT 'Administrator level',
			  `email` varchar(255) NOT NULL COMMENT 'E-mail address (not public)',
			  `title` enum('Dr','Mr','Ms','Miss','Mrs','Prof','Prof Sir') DEFAULT NULL COMMENT 'Title',
			  `forename` varchar(255) NOT NULL COMMENT 'Forename',
			  `surname` varchar(255) NOT NULL COMMENT 'Surname',
			  `biography` mediumtext COMMENT 'Biographical summary',
			  `url` mediumtext COMMENT 'Homepage URL',
			  PRIMARY KEY (`username__JOIN__people__people__reserved`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
			
			CREATE TABLE `aperture` (
			  `id` int NOT NULL AUTO_INCREMENT COMMENT 'Unique key',
			  `variant` varchar(255) NOT NULL COMMENT 'Main variant',
			  `subvariant` varchar(255) DEFAULT NULL COMMENT 'Sub-variant',
			  `subsubvariant` varchar(255) DEFAULT NULL COMMENT 'Sub-sub-variant',
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Aperture';
			
			CREATE TABLE `diameter` (
			  `id` int NOT NULL AUTO_INCREMENT COMMENT 'Unique key',
			  `variant` varchar(255) NOT NULL COMMENT 'Main variant',
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Equatorial diameter';
			
			CREATE TABLE `family` (
			  `id` int NOT NULL AUTO_INCREMENT COMMENT 'ID',
			  `family` varchar(255) NOT NULL,
			  `synonyms` mediumtext COMMENT 'Synonym(s)',
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Table of families';
			
			CREATE TABLE `features` (
			  `id` int NOT NULL AUTO_INCREMENT COMMENT 'Unique key',
			  `variant` varchar(255) NOT NULL COMMENT 'Main variant',
			  `subvariant` varchar(255) DEFAULT NULL COMMENT 'Sub-variant',
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Useful diagnostic features';
			
			CREATE TABLE `form` (
			  `id` int NOT NULL AUTO_INCREMENT COMMENT 'Unique key',
			  `variant` varchar(255) NOT NULL COMMENT 'Main variant',
			  `subvariant` varchar(255) DEFAULT NULL COMMENT 'Sub-variant',
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Form';
			
			CREATE TABLE `imagesources` (
			  `id` int NOT NULL AUTO_INCREMENT COMMENT 'Unique key',
			  `websiteName` varchar(255) DEFAULT NULL COMMENT 'Website name',
			  `institution` varchar(255) DEFAULT NULL COMMENT 'Institution',
			  `category` enum('Database','Collection','Atlas','Glossary','Other') DEFAULT NULL COMMENT 'Category',
			  `urlFrontPage` mediumtext COMMENT 'Front page URL',
			  `urlImages` mediumtext COMMENT 'Images index URL',
			  `lmImages` enum('','Yes','No') DEFAULT NULL COMMENT 'LM images',
			  `semImages` enum('','Yes','No') DEFAULT NULL COMMENT 'SEM images',
			  `descriptions` enum('','Yes','No') DEFAULT NULL COMMENT 'Descriptions',
			  `glossary` enum('','Yes','No') DEFAULT NULL COMMENT 'Glossary',
			  `numberOfTaxa` int DEFAULT NULL COMMENT 'Approximate number of taxa',
			  `publicNotes` mediumtext COMMENT 'Public notes',
			  `privateNotes` mediumtext COMMENT 'Private notes',
			  `copyrightStatus` enum('Copyright status unsure','Permission granted to reproduce','Permission granted on limited basis (add details to notes)','Copyright approval needed','No right to reproduce') NOT NULL DEFAULT 'Copyright status unsure' COMMENT 'Copyright',
			  `copyrightNoteste` mediumtext COMMENT 'Copyright notes',
			  `appearInList` enum('','Yes','No') NOT NULL DEFAULT 'No' COMMENT 'Show this URL in list of links?',
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Table of image sources';
			
			CREATE TABLE `materials` (
			  `id` int NOT NULL AUTO_INCREMENT COMMENT 'Unique key',
			  `pollen__JOIN__pollen__pollen__reserved` int NOT NULL COMMENT 'Pollen database number',
			  `productionNumber` varchar(255) DEFAULT NULL COMMENT 'Production number',
			  `residueStatus` enum('','NR [No residue]','Residue present') NOT NULL COMMENT 'Residue status',
			  `mountant` enum('','GJ [Glycerine Jelly]','SO [Silicon oil]','xGJ [Extracted from Glycerine Jelly]') DEFAULT NULL COMMENT 'Mountant',
			  `slideStatus` varchar(255) DEFAULT NULL COMMENT 'Slide status',
			  `storageLocation` varchar(255) DEFAULT NULL COMMENT 'Storage location',
			  `publicNotes` mediumtext COMMENT 'Visible notes',
			  `privateNotes` mediumtext COMMENT 'Private notes',
			  PRIMARY KEY (`id`),
			  KEY `pollen__JOIN__pollen__pollen__reserved` (`pollen__JOIN__pollen__pollen__reserved`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Table of materials';
			
			CREATE TABLE `media` (
			  `id` int NOT NULL AUTO_INCREMENT COMMENT 'Unique key',
			  `pollen__JOIN__pollen__pollen__reserved` int DEFAULT NULL COMMENT 'Pollen database number',
			  `residue` varchar(255) DEFAULT NULL COMMENT 'Residue',
			  `type` enum('Reference image (item from {$this->settings['collectionName']})','Image (taken from external source)','Video (taken from external source)','Document') DEFAULT NULL COMMENT 'Type',
			  `filename` varchar(255) DEFAULT NULL COMMENT 'File attachment',
			  `url` mediumtext COMMENT 'URL of source file',
			  `copyrightStatus` enum('Copyright status unsure','Permission granted to reproduce','Permission granted on limited basis (add details to notes)','Copyright approval needed','No right to reproduce') NOT NULL DEFAULT 'Copyright status unsure' COMMENT 'Copyright',
			  `copyrightNotes` mediumtext COMMENT 'Copyright notes',
			  `shortDescription` varchar(255) NOT NULL COMMENT 'Short description',
			  `doi` varchar(255) DEFAULT NULL COMMENT 'DOI reference number',
			  `publicNotes` mediumtext COMMENT 'Public notes',
			  `privateNotes` mediumtext COMMENT 'Private notes',
			  PRIMARY KEY (`id`),
			  KEY `pollen__JOIN__pollen__pollen__reserved` (`pollen__JOIN__pollen__pollen__reserved`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Table of media (images/videos)';
			
			CREATE TABLE `polaraxis` (
			  `id` int NOT NULL AUTO_INCREMENT COMMENT 'Unique key',
			  `variant` varchar(255) NOT NULL COMMENT 'Main variant',
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Polar axis';
			
			CREATE TABLE `pollen` (
			  `id` int NOT NULL COMMENT 'Record number',
			  `family__JOIN__pollen__family__reserved` int DEFAULT NULL COMMENT 'Family',
			  `subfamily__JOIN__pollen__subfamily__reserved` int DEFAULT NULL COMMENT 'Sub-Family',
			  `genus` varchar(255) DEFAULT NULL COMMENT 'Genus',
			  `species` varchar(255) DEFAULT NULL COMMENT 'Species',
			  `FENumber` varchar(255) DEFAULT NULL COMMENT 'Flora Europaea',
			  `englishCommonName` varchar(255) DEFAULT NULL COMMENT 'English common name',
			  `continent` set('Africa','Antarctica','Asia','Australia','Europe','North America','South America') DEFAULT NULL COMMENT 'Continent',
			  `furtherLocationDetails` varchar(255) DEFAULT NULL COMMENT 'Further geographical location details',
			  `fossilType` enum('','Pollen','Spore') NOT NULL DEFAULT 'Pollen' COMMENT 'Fossil type',
			  `form__JOIN__pollen__form__reserved` int DEFAULT NULL COMMENT 'Form',
			  `alternativeForm__JOIN__pollen__form__reserved` int DEFAULT NULL COMMENT 'Alternative form',
			  `primaryApertureConfiguration__JOIN__pollen__aperture__reserved` int DEFAULT NULL COMMENT 'Primary aperture configuration',
			  `alternativeaApertureConfig1__JOIN__pollen__aperture__reserved` int DEFAULT NULL COMMENT 'Alternative aperture configuration 1',
			  `alternativeaApertureConfig2__JOIN__pollen__aperture__reserved` int DEFAULT NULL COMMENT 'Alternative aperture configuration 2',
			  `alternativeaApertureConfig3__JOIN__pollen__aperture__reserved` int DEFAULT NULL COMMENT 'Alternative aperture configuration 3',
			  `primarySculpturingType__JOIN__pollen__sculpturing__reserved` int DEFAULT NULL COMMENT 'Primary sculpturing type',
			  `alternativeSculpturingType1__JOIN__pollen__sculpturing__reserved` int DEFAULT NULL COMMENT 'Alternative sculpturing type 1',
			  `alternativeSculpturingType2__JOIN__pollen__sculpturing__reserved` int DEFAULT NULL COMMENT 'Alternative sculpturing type 2',
			  `alternativeSculpturingType3__JOIN__pollen__sculpturing__reserved` int DEFAULT NULL COMMENT 'Alternative sculpturing type 3',
			  `tectum__JOIN__pollen__tectum__reserved` int DEFAULT NULL COMMENT 'Tectum [Wall Structure]',
			  `primaryPolarAxis__JOIN__pollen__polaraxis__reserved` int DEFAULT NULL COMMENT 'Primary polar axis',
			  `alternativePolarAxis1__JOIN__pollen__polaraxis__reserved` int DEFAULT NULL COMMENT 'Alternative polar axis 1',
			  `primaryEquatorialDiameter__JOIN__pollen__diameter__reserved` int DEFAULT NULL COMMENT 'Primary equatorial diameter',
			  `alternativeEquatorialDiameter1__JOIN__pollen__diameter__reserved` int DEFAULT NULL COMMENT 'Alternative equatorial diameter 1',
			  `features1__JOIN__pollen__features__reserved` int DEFAULT NULL COMMENT 'Useful diagnostic features (1)',
			  `features2__JOIN__pollen__features__reserved` int DEFAULT NULL COMMENT 'Useful diagnostic features (2)',
			  `features3__JOIN__pollen__features__reserved` int DEFAULT NULL COMMENT 'Useful diagnostic features (3)',
			  `references` mediumtext COMMENT 'References',
			  `urls` mediumtext COMMENT 'URLs (and description)',
			  `ecologicalPreferences` mediumtext COMMENT 'Ecological preferences',
			  `notes` mediumtext COMMENT 'Visible notes',
			  `privateNotes` mediumtext COMMENT 'Private notes',
			  `recordCreation` datetime DEFAULT NULL COMMENT 'Record creation date/time',
			  `lastModified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Date/time when record last modified',
			  `userCreator` varchar(255) NOT NULL COMMENT 'Original creator',
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Pollen samples';
			
			CREATE TABLE `sculpturing` (
			  `id` int NOT NULL AUTO_INCREMENT COMMENT 'Unique key',
			  `sculpturing` varchar(255) NOT NULL COMMENT 'Main variant',
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Sculpturing';
			
			CREATE TABLE `subfamily` (
			  `id` int NOT NULL COMMENT 'ID',
			  `family` varchar(255) NOT NULL,
			  `synonyms` mediumtext COMMENT 'Synonym(s)',
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Table of sub-families';
			
			CREATE TABLE `tectum` (
			  `id` int NOT NULL AUTO_INCREMENT COMMENT 'Unique key',
			  `variant` varchar(255) NOT NULL COMMENT 'Main variant',
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Tectum [Wall Structure]';
		";
	}
	
	
	
	# Welcome screen
	public function home ()
	{
		# Start the HTML
		$html = '';
		
		# Define edit link
		$editLink = '';
		if ($this->userIsAdministrator) {
			$editLink = "\n<li><a rel=\"nofollow\" href=\"{$this->baseUrl}/articles/add.html\">Add new articles or edit existing articles in the collection</a></li>";
		}
		
		# Define the HTML
		if ($this->settings['introductionHtml']) {
			$placeholders = array (
				'%baseUrl' => $this->baseUrl,
				'%editLink' => $editLink,
			);
			$html .= strtr ($this->settings['introductionHtml'], $placeholders);
		}
		
		# Add comments note
		$html .= "<p>Comments/suggestions via the <a href=\"{$this->baseUrl}/feedback.html\">feedback form</a> are most welcome.</p>";
		
		# Show the HTML
		echo $html;
	}
	
	
	# Copyright screen
	public function copyright ()
	{
		# Show the introduction
		$html  = "\n" . "<p>All images on this site are &copy; {$this->settings['copyrightOwner']}.</p>";
		$html .= "\n" . "<p>If you wish to reproduce an item, please kindly <a href=\"{$this->baseUrl}/feedback.html\">contact us</a> in the first instance.</p>";
		
		# Return the HTML
		echo $html;
	}
	
	
	# Help page; overrides default help page
	public function help ()
	{
		# Define the HTML
		$html  = '
			<h3>Database access</h3>
			<p>This database can be viewed by anyone.</p>
			<p>Certain images are copyright reserved, so cannot be viewed on external computers.</p>
			<p>This database can only be edited by registered users. Registered users can only be created by current administrators. Administrators login is via the University\'s Raven system.</p>
			<h3>Using the database</h3>
			<p>In view mode, empty fields are hidden.</p>
			<p>Depending on the browser in use, refreshing a page may remove entered but unsubmitted information. In order to refresh drop down menus from look-up tables, please use the refresh button next to the drop down menus.</p>
			<h3>Copyright statement</h3>
			<p>All original images / videos are copyright reserved.</p>
			<p>Only openly-licensed images are reproduced. If you believe we have infringed on your copyright, please let us know and we will make the necessary corrections.</p>
		';
		
		# Show the HTML
		echo $html;
	}
	
	
	# Links page
	public function links ()
	{
		# Get the static HTML file
		$html  = file_get_contents ($_SERVER['DOCUMENT_ROOT'] . $this->baseUrl . '/links.html');
		
		# Show the HTML
		echo $html;
	}
	
	
	# Function to clear search and other parameters
	public function clear ()
	{
		# Reset the session
		session_start ();
		$_SESSION = array ();
		
		# Redirect to main page
		$location = 'https://' . $_SERVER['SERVER_NAME'] . $this->baseUrl . '/articles/';
		header ("Location: {$location}");
	}
	
	
	# Search form
	private function searchForm ()
	{
		# Create the form
		$template = "{[[PROBLEMS]]}\n<p>Limit to: {family} {genus} {species}{[[SUBMIT]]} &nbsp;&nbsp;&nbsp;&nbsp;[or <a rel=\"nofollow\" href=\"{$this->baseUrl}/articles/clear.html\">reset all</a>]</p>";
		$form = new form (array (
			'displayRestrictions' => false,
			'formCompleteText' => false,
			'escapeOutput' => true,
			'databaseConnection' => $this->databaseConnection,
			'div' => 'ultimateform article',
			'reappear' => true,
			'display' => 'template',
			'displayTemplate' => $template,
			'submitButtonText' => 'Search!',
			'submitButtonAccesskey' => false,
			'nullText'	=> false,
			'requiredFieldIndicator' => false,
			'escapeOutput' => true,
		));
		
		# Get the data
		#!# Add in trimSql ()
		$query = "SELECT
			DISTINCT
				family.family,
				family__JOIN__pollen__family__reserved
			FROM {$this->dataSource}
			LEFT OUTER JOIN pollen.family ON pollen.family__JOIN__pollen__family__reserved = family.id
			WHERE family__JOIN__pollen__family__reserved != '0'
			ORDER BY family
		;";
		$familyData = $this->databaseConnection->getData ($query);
		$query = "SELECT DISTINCT genus FROM {$this->dataSource} ORDER BY genus;";
		$genus = $this->databaseConnection->getPairs ($query);
		$query = "SELECT DISTINCT species FROM {$this->dataSource} ORDER BY species;";
		$species = $this->databaseConnection->getPairs ($query);
		
		# Re-arrange the family
		$family = array ();
		foreach ($familyData as $familyItem) {
			$family[$familyItem['family__JOIN__pollen__family__reserved']] = trim ($familyItem['family']);
		}
		
		# Form widgets
		$form->select (array ( 
		    'name'		=> 'family',
		    'title'		=> 'Family',
		    'values'	=> $family,
			'nullText'	=> '[Family]',
			'default'	=> (isSet ($_SESSION['family']) ? $_SESSION['family'] : ''),
			'forceAssociative' => true,	// Ensures index is kept
		));
		$form->select (array ( 
		    'name'		=> 'genus',
		    'title'		=> 'Genus',
			'values'	=> $genus,
			'nullText'	=> '[Genus]',
			'default'	=> (isSet ($_SESSION['genus']) ? $_SESSION['genus'] : ''),
		));
		$form->select (array ( 
		    'name'		=> 'species',
		    'title'		=> 'Species',
		    'values'	=> $species,
			'nullText'	=> '[Species]',
			'default'	=> (isSet ($_SESSION['species']) ? $_SESSION['species'] : ''),
		));
		
		# Process the form
		$result = $form->process ($html);
		
		# Default to the session
		if (!$result) {
			if (isSet ($_SESSION['family'])) {$result['family'] = $_SESSION['family'];}
			if (isSet ($_SESSION['genus'])) {$result['genus'] = $_SESSION['genus'];}
			if (isSet ($_SESSION['species'])) {$result['species'] = $_SESSION['species'];}
		}
		
		# Return the result
		return $result;
	}
	
	
	# Articles listing screen
	public function articles ($restrictionSql = '', $preparedStatementValues = array ())
	{
		# Assign the field ordering
		$orderby = $this->settings['orderby'];
		$firstOrderby = $orderby[0];
		$this->arguments['orderby'] = $orderby[0];
		if (isSet ($_GET['orderby']) && in_array ($_GET['orderby'], $orderby)) {
			$orderby = application::array_move_to_start ($this->settings['orderby'], $_GET['orderby']);
			$firstOrderby = $_GET['orderby'];
			$this->arguments['orderby'] = $firstOrderby;
		}
		
		# Determine the page to use
		$usePage = ((isSet ($_GET['page']) && is_numeric ($_GET['page']) && ($_GET['page'])) ? $_GET['page'] : 1);
		
		# Put the ordering and page into the session and redirect if on the main page
		session_start ();
		if (!isSet ($_GET['orderby']) && !isSet ($_GET['page'])) {
			if (isSet ($_SESSION['orderby']) && isSet ($_SESSION['page'])) {
				if (in_array ($_SESSION['orderby'], $orderby) && is_numeric ($_SESSION['page'])) {	// Page could be checked further
					$location = 'https://' . $_SERVER['SERVER_NAME'] . $this->baseUrl . "/articles/{$_SESSION['orderby']},page{$_SESSION['page']}.html";
					header ("Location: {$location}");
					return;
				}
			}
		} else {
			$_SESSION['orderby'] = $this->arguments['orderby'];
			$_SESSION['page'] = $usePage;
		}
		
		# Show the search form and create SQL from it
		if ($result = $this->searchForm ()) {
			#!# Session reset is a workaround for offsets bug
			$restrictions = array ();
			$preparedStatementValues = array ();
			foreach ($result as $key => $value) {
				$_SESSION[$key] = $value;
				if ($value) {
					if ($key == 'family') {$key = "family__JOIN__{$this->settings['database']}__family__reserved";}
					$restrictions[] = "{$key} = :{$key}";
					$preparedStatementValues[$key] = $value;
				}
			}
			if ($restrictions) {
				$restrictionSql = ' WHERE ' . implode (' AND ', $restrictions);
			}
			
			# Redirect to main page to prevent POST refresh warnings
			if ($_POST) {
				$location = 'https://' . $_SERVER['SERVER_NAME'] . $this->baseUrl . '/articles/';
				header ("Location: {$location}");
			}
		}
		
		# Get the data or end
		list ($data, $totalArticles, $totalPages, $page) = $this->getArticlesData ($restrictionSql, $preparedStatementValues, $orderby, $usePage);
		if (!$data) {
			echo $html = '<p>No articles were found.</p>';
			return false;
		}
		
		# Start the HTML with the number of records
		$articlesShown = count ($data);
		$html  = "\n<p>There " . ($totalArticles == 1 ? 'is one taxon' : "are {$totalArticles} taxa") .  (($totalArticles != $articlesShown) ? ', of which ' . ($articlesShown == 1 ? 'one is shown' : "{$articlesShown} are shown") : '') . ':</p>';
		
		# Add in pagination links
		$paginationListHtml = pagination::paginationLinks ($page, $totalPages, $this->baseUrl . '/articles/' . $firstOrderby . ',');
		$html .= $paginationListHtml;
		
		# Rearrange the table
		foreach ($data as $key => $article) {
			
			# Add the view/edit links
			$data[$key]['materials'] = ($data[$key]['materials'] == '0' ? '' : $data[$key]['materials']);
			$data[$key]['media'] = ($data[$key]['media'] == '0' ? '' : $data[$key]['media']);
			$data[$key]['view'] = "<a href=\"{$this->baseUrl}/articles/" . strtolower ($article['id']) . '/"><strong>View</strong></a>';
			$data[$key]['edit'] = "<a rel=\"nofollow\" href=\"{$this->baseUrl}/articles/" . strtolower ($article['id']) . '/edit.html">Edit</a>';
			
			# Unset the id
			unset ($data[$key]['id']);
		}
		
		# Create table headings
		$replacements = array ();
		foreach ($orderby as $heading) {
			$replacements[$heading] = '<a' . ($heading == $this->arguments['orderby'] ? ' class="selected"' : '') . ' href="' . (($heading == $firstOrderby) ? './' : "{$heading}.html") .  '">' . ucfirst ($heading) . '</a>';
		}
		
		# Compile the HTML
		$html .= application::htmlTable ($data, $replacements, $class = 'lines articles', $showKey = false, $uppercaseHeadings = true, $allowHtml = true, $showColons = false, $addCellClasses = true, $addRowKeys = false);
		$html .= "\n<br />" . $paginationListHtml;
		
		# Link to a mass dump of records
		if ($this->userIsAdministrator) {
			$html .= "<br /><p>As an administrator, you can also print off a <a href=\"{$this->baseUrl}/articles/dump.html\">full dump of all articles</a>.</p>";
		}
		
		# Show the HTML
		echo $html;
	}
	
	
	# Function to get data for several articles
	private function getArticlesData ($restrictionSql = '', $preparedStatementValues = array (), $orderby = false, $page = 0, $dumpMode = false)
	{
		# Apply pagination if a page supplied
		if ($page) {
			
			# Count the articles
			#!# Switch to database.php method when it has $preparedStatementValues support
			//$totalRecords = $this->databaseConnection->getTotal ($this->settings['database'], $this->settings['table'], $restrictionSql);
			$query = "SELECT COUNT(*) AS total FROM `{$this->settings['database']}`.`{$this->settings['table']}` {$restrictionSql};";
			$totalRecords = $this->databaseConnection->getOneField ($query, 'total', $preparedStatementValues);
			
			# Get pager data
			list ($totalPages, $offset, $items, $limit, $page) = pagination::getPagerData ($totalRecords, $this->settings['maxArticlesPerPage'], $page);
		}
		
		/*
		# IsNull technique at: https://www.shawnolson.net/a/730/mysql_sort_order_with_null.html
		foreach ($orderby as $index => $item) {
			$orderby[$index] = $item . 'IsNull';
		}
			IsNull technique at: https://www.shawnolson.net/a/730/mysql_sort_order_with_null.html
			, IF(family.family IS NULL or family.family='', 1, family.family) AS familyIsNull
			, IF(pollen.genus IS NULL or pollen.genus='', 1, pollen.genus) AS genusIsNull
			, IF(pollen.species IS NULL or family.family='', 1, pollen.species) AS speciesIsNull
			
		*/
		
		# Dump mode query
		if ($dumpMode) {
			$query = "SELECT
				pollen.id,
				family.family,
				pollen.genus,
				pollen.FENumber,
				COUNT(materials.id) AS materials
			FROM {$this->dataSource}
			LEFT OUTER JOIN pollen.materials ON pollen.id = materials.pollen__JOIN__pollen__pollen__reserved
			LEFT OUTER JOIN pollen.family ON pollen.family__JOIN__pollen__family__reserved = family.id
			/* WHERE materials <> 0 */
			GROUP BY pollen.id
			ORDER BY genus;";
			
		} else {
			
			$query = "SELECT
				pollen.id,
				family.family,
				pollen.genus,
				pollen.species,
				COUNT(materials.id) AS materials
				, COUNT(media.id) AS media
			FROM {$this->dataSource}
			LEFT OUTER JOIN pollen.materials ON pollen.id = materials.pollen__JOIN__pollen__pollen__reserved
			LEFT OUTER JOIN pollen.media ON pollen.id = media.pollen__JOIN__pollen__pollen__reserved
			LEFT OUTER JOIN pollen.family ON pollen.family__JOIN__pollen__family__reserved = family.id
			"
			. $restrictionSql
			. ' GROUP BY pollen.id'
			. ($orderby ? ' ORDER BY ' . implode (',', $orderby) : '')
			. ($page ? " LIMIT {$offset}, {$limit}" : '')
			. ';';
		}
		
		if (!$data = $this->databaseConnection->getData ($query, $this->dataSource, true, $preparedStatementValues)) {
			return ($page ? array (false, 0, 0, 0) : false);
		}
		
		# Return the data
		return ($page ? array ($data, $totalRecords, $totalPages, $page) : $data);
	}
	
	
	# Function to produce a printable dump of all articles
	public function dump ()
	{
		# Start the HTML
		$html  = '<p>This is a dump of all articles, one after the other.<br />(Printing will result in page breaks at sensible locations.)</p>';
		
		# Get the data or end
		if (!$data = $this->getArticlesData ('', array (), false, 0, $dumpMode = true)) {
			echo $html = '<p>No articles were found.</p>';
			return false;
		}
		
		# Display the data
		#!# TODO
		$html = application::htmlTable ($data);
		/*
		# Create the list of records
		foreach ($data as $key => $article) {
			$list[] = "<a href=\"#article{$key}\">Article " . htmlspecialchars (implode (' - ', $article)) . '</a>';
		}
		$html .= application::htmlUl ($list);
		
		# Loop through each article and create the HTML for it
		foreach ($data as $key => $article) {
			$html .= '<hr class="pagebreak" />';
			$html .= $this->articleManipulation ($key, $action = __FUNCTION__);
		}
		*/
		
		# Show the HTML
		echo $html;
	}
	
	
	# Article viewing - wrapper to main article
	public function article ($article)
	{
		# Hand off to the article method, in addition mode
		echo $this->articleManipulation ($article);
	}
	
	
	# Article addition - wrapper to main article
	public function add ()
	{
		# Hand off to the article method, in addition mode
		echo $this->articleManipulation (false, $action = __FUNCTION__);
	}
	
	
	# Article editing - wrapper to main article
	public function edit ($article)
	{
		# Hand off to the article method, in edit mode
		echo $this->articleManipulation ($article, $action = __FUNCTION__);
	}
	
	
	# Article editing - materials section
	public function editmaterial ($article)
	{
		echo $this->articleManipulation ($article, $action = __FUNCTION__);
	}
	
	
	# Article editing - media section
	public function editmedia ($article)
	{
		echo $this->articleManipulation ($article, $action = __FUNCTION__);
	}
	
	
	# Article addition - materials section
	public function addmaterial ($article)
	{
		echo $this->articleManipulation ($article, $action = __FUNCTION__);
	}
	
	
	# Media addition - material section
	public function addmaterialmedia ($article)
	{
		echo $this->articleManipulation ($article, $action = __FUNCTION__);
	}
	
	
	# Article addition - media section
	public function addmedia ($article)
	{
		echo $this->articleManipulation ($article, $action = __FUNCTION__);
	}
	
	
	# Article cloning - wrapper to main article
	public function clonerecord ($article)
	{
		# Hand off to the article method, in edit mode
		echo $this->articleManipulation ($article, $action = 'clone');
	}
	
	
	# Article deletion - wrapper to main article
	public function delete ($article)
	{
		# Hand off to the article method, in edit mode
		echo $this->articleManipulation ($article, $action = __FUNCTION__);
	}
	
	
	# Function to construct an item's name
	private function constructName ($data, $fields = false)
	{
		# Get fields if necessary
		if (!$fields) {
			$fields = $this->databaseConnection->getFields ($this->settings['database'], $this->settings['table']);
		}
		
		# Convert the name
		$dataset = array ($data);
		$dataset = $this->databaseConnection->substituteJoinedData ($dataset, $this->settings['database'], false, $nameField = 'family');
		$data = $dataset[0];
		
		# Compile the name from the specified fields that are non-empty
		$nameComponents = array ();
		$useFields = array ('family__JOIN__pollen__family__reserved', 'genus', 'species');
		foreach ($useFields as $field) {
			if (isSet ($data[$field]) && !empty ($data[$field])) {
				$nameComponents[] = $data[$field];
			}
		}
		$name = implode (' ', $nameComponents);
		
		# Make entity-safe
		$name = htmlspecialchars ($name);
		
		# Return the assembled name
		return $name;
	}
	
	
	# Function to create previous/index/next navigation links
	private function navigationLinks ($article, $actionSupplement = '')
	{
		# Start the HTML
		$html  = '';
		
		# Ensure a record is numeric
		if (($article) && ctype_digit ($article)) {
			
			# Determine the article and ordering
			session_start ();
			$firstOrderby = ((isSet ($_SESSION['orderby']) && in_array ($_SESSION['orderby'], $this->settings['orderby'])) ? $_SESSION['orderby'] : $this->settings['orderby'][0]);
			$orderby = application::array_move_to_start ($this->settings['orderby'], $firstOrderby);
			
			# Get the previous/next record; note that the technique at https://jystewart.net/2005/06/27/nextprevious-with-mysql/ cannot be used as title is not necessary unique
			$data = $this->getArticlesData ('', array (), $orderby, $page = false);
			$positions = application::getPositions (array_keys ($data), $article);
			
			# Create the links
			$links['first'] = ($positions['start'] ? "<a href=\"{$this->baseUrl}/articles/{$positions['start']}/{$actionSupplement}\" title=\"First record ({$positions['start']})\">&laquo;</a>" : '&nbsp;');
			$links['previous'] = ($positions['previous'] ? "<a href=\"{$this->baseUrl}/articles/{$positions['previous']}/{$actionSupplement}\" title=\"Previous record ({$positions['previous']})\">&lt; Previous</a>" : '&nbsp;');
			$links['index'] = "<a href=\"{$this->baseUrl}/articles/\" title=\"Return to index of all " . ucfirst ($firstOrderby) . " records\">" . ucfirst ($firstOrderby) . ' index</a>';
			$links['next'] = ($positions['next'] ? "<a href=\"{$this->baseUrl}/articles/{$positions['next']}/{$actionSupplement}\" title=\"Next record ({$positions['next']})\">Next &gt;</a>" : '&nbsp;');
			$links['last'] = ($positions['end'] ? "<a href=\"{$this->baseUrl}/articles/{$positions['end']}/{$actionSupplement}\" title=\"Last record ({$positions['end']})\">&raquo;</a>" : '&nbsp;');
			
			# Compile the links
			$html .= "\n" . application::htmlUl ($links, $parentTabLevel = 0, $className = 'noprint', $ignoreEmpty = true, $sanitise = false, $nl2br = false, $liClass = true, $selected = true);
		}
		
		# Return the HTML
		return $html;
	}
	
	
	# Article page, defaulting to viewing
	private function articleManipulation ($article = false, $action = 'view')
	{
		# Special handling of dump mode
		$dumpMode = false;
		if ($action == 'dump') {
			$action = 'view';
			$dumpMode = true;
		}
		
		# Determine the available actions
		$actions = array ('view', 'edit', 'clone', 'delete', 'add');
		
		# Get the article data or end
		if ($action != 'add') {
			if (!$articleData = $this->getArticleData ($article)) {return false;}
		}
		
		# Get the fields and headings conversions
		$articleFields = $this->databaseConnection->getFields ($this->settings['database'], $this->settings['table']);
		$articleHeadings = $this->databaseConnection->getHeadings ($this->settings['database'], $this->settings['table'], $articleFields);
		
		# Get the materials data
		$materialsData = $this->databaseConnection->select ($this->settings['database'], 'materials', array ('pollen__JOIN__pollen__pollen__reserved' => $article));
		$materialsHeadings = $this->databaseConnection->getHeadings ($this->settings['database'], 'materials');
		
		# Get the media data and regroup it by residue
		$mediaDataRaw = $this->getArticleMediaData ($article);
		foreach ($mediaDataRaw as $index => $media) {
			if ($media['residue'] == '') {
				$mediaDataRaw[$index]['residue'] = 0;	// '' is changed to: 0, which is being used as a special case meaning 'not attached to a specific residue/material'
			}
		}
		$mediaData = application::regroup ($mediaDataRaw, 'residue', $removeGroupColumn = false);
		$mediaFields = $this->databaseConnection->getFields ($this->settings['database'], 'media');
		
		# Determine whether to limit the fields (which is the default, i.e. $article/ rather than $article/full.html
		$fullView = (($this->action == 'dump') || (isSet ($_GET['full']) && $_GET['full'] == 'true'));
		$limitFields = ($fullView ? false : array ('id', 'pollen__JOIN__pollen__pollen__reserved', 'filename', 'url', 'shortDescription', 'publicNotes', 'copyrightStatus'));
		
		# Start the HTML
		$html  = '';
		
		# Add the name
		if ($action != 'add') {
			$html .= "\n" . "<h2 id=\"article{$article}\">" . $this->constructName ($articleData, $articleFields) . '</h2>';
		}
		
		# Create navigation links if showing/manipulating an existing article
		$html .= "\n<div class=\"location noprint\">";
		$html .= $this->navigationLinks ($article, ($action == 'view' ? '' : "{$action}.html"));
		$html .= "\n</div>";
		
		# Viewing mode links
		if ($action != 'add') {
			$html .= "\n<p class=\"noprint\">" . ($fullView ? '<a href="./#media">Return to default viewing mode</a>' : '<a href="full.html#media">View in full view mode</a>') . '</p>';
		}
		
		# Show links to materials and media
		$attachments = array ();
		$totalMaterials = count ($materialsData);
		if ($materialsData) {$attachments[] = "\n<a href=\"#materials\"><img src=\"/images/icons/image.png\" alt=\"Material\" class=\"icon\" /> " . ($totalMaterials == 1 ? 'one material' : "{$totalMaterials} materials") . '</a>';}
		$totalMedia = count ($mediaDataRaw);
		if ($mediaData) {$attachments[] = "\n<a href=\"#media\"><img src=\"/images/icons/picture.png\" alt=\"Media\" class=\"icon\" /> " . ($totalMedia == 1 ? 'one media item' : "{$totalMedia} media items") . '</a>';}
		if ($attachments) {
			$html .= "\n<p>This item has: " . implode (' and ', $attachments)  . '</p>';
		}
		
		# Display the record
		$html .= "\n<div class=\"pollen\">";
		$html .= "\n\n<h3 id=\"pollen\">Data for this pollen</h3>";
		$addRecord = ($action == 'add');
		$editRecord = ($action == 'edit');
		if (!$addRecord) {
			$html .= "\n<ul class=\"actions noprint\">";
			if ($editRecord) {
				$html .= "<li><a rel=\"nofollow\" href=\"{$this->baseUrl}/articles/{$article}/#pollen\"><img src=\"/images/icons/table_delete.png\" alt=\"Cancel\" /> Cancel editing</a></li>";
			} else {
				$html .= "<li><a rel=\"nofollow\" href=\"{$this->baseUrl}/articles/{$article}/edit.html#pollen\"><img src=\"/images/icons/page_white_edit.png\" alt=\"Edit\" /> Edit main record</a></li>";
			}
			$html .= "\n</ul>";
		}
		if ($addRecord || $editRecord) {
			$html .= $this->editableRegion ($article, $action, 'pollen', ($addRecord ? false : $articleData), 'pollen');
		} else {
			$html .= $this->displayRecord ($article, $articleData, $articleFields, $fullView);
		}
		$html .= "\n</div>";
		
		# End here if adding a main record
		if ($addRecord) {
			return $html;
		}
		
		# Start materials section
		$html .= "\n\n<h3 id=\"materials\">Examples of this taxon in the {$this->settings['collectionName']}</h3>";
		
		# Get material data
		if (!$materialsData) {
			$html .= "\n<p>There are no examples of this taxon in the {$this->settings['collectionName']}.</p>";
		}
		
		# Material addition
		if ($action == 'addmaterial') {
			$html .= "\n<div class=\"material\">";
			$html .= "\n<h4 id=\"addmaterial\"><img src=\"/images/icons/image.png\" alt=\"Media\" class=\"icon\" /> Add new material</h4>";
			$html .= "\n<ul class=\"actions noprint\">
				<li><a rel=\"nofollow\" href=\"{$this->baseUrl}/articles/{$article}/#addmaterial\"><img src=\"/images/icons/image_delete.png\" alt=\"Cancel\" /> Cancel adding material</a></li>
			</ul>";
			$html .= $this->editableRegion ($article, $action, 'materials', array (), 'addmaterial');
			$html .= "\n</div>";
		} else {
			
			# Action link
			$html .= "\n<ul class=\"actions inline noprint\" id=\"addmaterial\"><li><a rel=\"nofollow\" href=\"{$this->baseUrl}/articles/{$article}/addmaterial.html#addmaterial\"><img src=\"/images/icons/picture_add.png\" class=\"icon\" alt=\"Add material\" /> Add material</a></li></ul>";
		}
		
		# Show any existing material by looping through each
		if ($materialsData) {
			foreach ($materialsData as $materialId => $material) {
				
				# Open a box
				$html .= "\n<div class=\"material\">";
				
				# Determine if a material is being edited
				$editMaterial = (($action == 'editmaterial' && isSet ($_GET['record']) && $_GET['record'] == $materialId) ? $materialId : false);
				$addMaterialMedia = (($action == 'addmaterialmedia' && isSet ($_GET['record']) && $_GET['record'] == $materialId) ? $materialId : false);
				
				# Show through each connected material
				$html .= "\n\n<h4 id=\"material{$materialId}\"><img src=\"/images/icons/image.png\" alt=\"Material\" class=\"icon\"> Production number: {$material['productionNumber']}</h4>";
				$html .= "\n<ul class=\"actions noprint\">";
				if ($editMaterial) {
					$html .= "<li><a rel=\"nofollow\" href=\"{$this->baseUrl}/articles/{$article}/#material{$materialId}\"><img src=\"/images/icons/table_delete.png\" alt=\"Cancel\" /> Cancel editing</a></li>";
				} else {
					$html .= "<li><a rel=\"nofollow\" href=\"{$this->baseUrl}/articles/{$article}/editmaterial.html?record={$materialId}#material{$materialId}\"><img src=\"/images/icons/image_edit.png\" alt=\"Edit\" /> Edit this material</a></li>";
					$html .= "<li><a rel=\"nofollow\" target=\"_blank\" href=\"{$this->baseUrl}/data/materials/{$materialId}/delete.html#material{$materialId}\"><img src=\"/images/icons/cross.png\" alt=\"Delete\" /> Delete this material&hellip;</a></li>";
				}
				$html .= "</ul>";
				
				# Edit the material if in editing mode
				if ($editMaterial) {
					$html .= $this->editableRegion ($article, $action, 'materials', $material, "material{$materialId}");
					
				# Show the material if in viewing mode
				} else {
					unset ($material['pollen__JOIN__pollen__pollen__reserved']);
					$html .= application::htmlTableKeyed ($material, $materialsHeadings);
				}
				
				# Title if adding material or some exists
				if (isSet ($mediaData[$materialId]) || ($action == 'addmaterialmedia')) {
					$html .= "\n\n<h5>Media for this taxon:</h5>";
				}
				
				# Media addition
				if ($addMaterialMedia) {
					$html .= "\n<div class=\"media\">";
					$html .= "\n<h4 id=\"addmaterialmedia{$materialId}\"><img src=\"/images/icons/picture.png\" alt=\"Media\" class=\"icon\" /> Add new media item to this material</h4>";
					$html .= "\n<ul class=\"actions noprint\">
						<li><a rel=\"nofollow\" href=\"{$this->baseUrl}/articles/{$article}/#addmaterialmedia{$materialId}\"><img src=\"/images/icons/table_delete.png\" alt=\"Cancel\" /> Cancel adding media</a></li>
					</ul>";
					$html .= $this->editableRegion ($article, $action, 'media', array (), "addmaterialmedia{$materialId}", $materialId);
					$html .= "\n</div>";
				} else {
					
					# Action link
					$html .= "\n<ul class=\"actions inline noprint\" id=\"addmaterialmedia{$materialId}\"><li><a rel=\"nofollow\" href=\"{$this->baseUrl}/articles/{$article}/addmaterialmedia.html?record={$materialId}#addmaterialmedia{$materialId}\"><img src=\"/images/icons/picture_add.png\" class=\"icon\" alt=\"Add media to this material\" /> Add media to this material</a></li></ul>";
				}
				
				# Show the media data for this item
				if (isSet ($mediaData[$materialId])) {
					$materialsIdFlag = true;
					foreach ($mediaData[$materialId] as $key => $mediaItem) {
						$html .= $this->mediaDataHtml ($action, $mediaItem, $key, $article, $mediaFields, $limitFields, $materialId);
					}
				}
				
				# Close the box
				$html .= "\n</div>";
			}
		}
		
		# Show materials not connected to samples held in the collection
		$html .= "\n\n<h3" . (isSet ($materialsIdFlag) ? '' : ' id="media"') . ">Media for this taxon sourced from elsewhere</h3>";
		if (!isSet ($mediaData[0])) {
			$html .= "\n<p>There are at present no media for this taxon sourced from elsewhere.</p>";
		}
		
		# Media addition
		if ($action == 'addmedia') {
			$html .= "\n<div class=\"media\">";
			$html .= "\n<h4 id=\"addmedia\"><img src=\"/images/icons/picture.png\" alt=\"Media\" class=\"icon\" /> Add new external media item</h4>";
			$html .= "\n<ul class=\"actions noprint\">
				<li><a rel=\"nofollow\" href=\"{$this->baseUrl}/articles/{$article}/#addmedia\"><img src=\"/images/icons/table_delete.png\" alt=\"Cancel\" /> Cancel adding external media</a></li>
			</ul>";
			$html .= $this->editableRegion ($article, $action, 'media', array (), $action);
			$html .= "\n</div>";
		} else {
			
			# Action link
			$html .= "\n<ul class=\"actions inline noprint\" id=\"addmedia\"><li><a rel=\"nofollow\" href=\"{$this->baseUrl}/articles/{$article}/addmedia.html#addmedia\"><img src=\"/images/icons/picture_add.png\" class=\"icon\" alt=\"Add external media\" /> Add external media</a></li></ul>";
		}
		
		# Show each current material
		if (isSet ($mediaData[0])) {
			$fullView = (($this->action == 'dump') || (isSet ($_GET['full']) && $_GET['full'] == 'true'));
			foreach ($mediaData[0] as $key => $mediaItem) {
				$html .= $this->mediaDataHtml ($action, $mediaItem, $key, $article, $mediaFields, $limitFields);
			}
		}
		
		# Return the HTML
		return $html;
	}
	
	
	# Function to make editable regions of the page
	private function editableRegion ($pollenId, $action, $table, $data, $anchor, $materialId = false)
	{
		# Start the HTML
		$html  = '';
		
		# Determine the location
		$location = $_SERVER['REQUEST_URI'] . '#' . $anchor;
		
		# Create the form
		$form = new form (array (
			'name' => $action,
			'submitTo' => $location,
			'displayRestrictions' => false,
			'formCompleteText' => false,
			'escapeOutput' => true,
			'databaseConnection' => $this->databaseConnection,
			'div' => 'ultimateform article',
			'cols' => 60,
			'rows' => 4,
			'nullText' => '',	// Deliberately set to blank so that entered values are more easily scannable in what is a large form
			'richtextEditorBasePath' => ($this->ravenUser ? '/_ckeditor/' : '/_ckeditor2/'),
			'richtextEditorFileBrowser' => false,
			'richtextEditorFileBrowser' => false,
			'richtextEditorToolbarSet' => 'Basic',
			'richtextWidth' => 400,
			'richtextHeight' => 200,
		));
		
		# Defaults for automatic keys (which will now be non-editable)
		$keyAttributes['editable'] = false;
		if (!preg_match ('/^edit/', $action)) {
			#!# The first four values are a workaround for just placing the text '(automatically assigned)'
			$keyAttributes['type'] = 'select';
			$keyAttributes['forceAssociative'] = true;
			$keyAttributes['default'] = 1;
			$keyAttributes['discard'] = true;
			$keyAttributes['values'] = array (1 => '(Automatically assigned)');	// The value '1' is used to ensure it always validates, whatever the field specification is
		}
		
		# Add the key in by default
		$attributes['id'] = $keyAttributes;
		
		# Define table overrides
		switch ($table) {
			case 'pollen':
				$exclude = array ('recordCreation', 'lastModified');
				$attributes = array (
					#!# Add/clone needs to say 'automatically assigned' as the key
					'id' => array_merge ($keyAttributes, array ('heading' => array ('4' => 'Pollen and spore'))),
					'genus' => array ('description' => "First letter must be upper-case, or use special keyword 'spp.'", 'regexp' => '^[A-Z]'),
					'species' => array ('description' => "First letter must be lower-case, or use special keyword 'spp.'", 'regexp' => '^[a-z]'),
					'form__JOIN__pollen__form__reserved' => array ('heading' => array ('4' => 'Page descriptors', 'p' => 'For definitions please consult the <a href="https://www.paldat.org/terminology" target="_blank">PalDat pollen terminology</a> and the <a href="https://web.archive.org/web/20071222180405/http://www.bio.uu.nl/~palaeo/glossary/" target="_blank">Utrecht University pollen glossary</a>.')),
					'family__JOIN__pollen__family__reserved' => array ('forceAssociative' => true, 'description' => '(Any synonyms are displayed after current family name.)'),
					'ecologicalPreferences' => array ('heading' => array ('4' => 'Ecological preferences')),
					'notes' => array ('type' => 'richtext', 'heading' => array ('4' => 'Additional notes')),
					'lastModified' => array ('default' => 'timestamp', 'editable' => false,),
					'references' => array ('heading' => array ('4' => 'References'), 'type' => 'richtext', ),
					'urls' => array ('description' => 'One URL line; add description after with space, i.e.:<br />https://example.com/foo/bar.html Description text here<br />https://example.com/bar/foo.html Second URL description', ),
					'userCreator' => array ('editable' => false, 'default' => $this->user, ),
				);
				break;
				
			case 'materials':
				$exclude = array ('pollen__JOIN__pollen__pollen__reserved');
				break;
				
			case 'media':
				$exclude = array ('pollen__JOIN__pollen__pollen__reserved', 'residue');
				$attributes = array (
					'id' => $keyAttributes,
					'residue' => array ('editable' => (!$materialId)),
					'type' => array ('values' => ($materialId ? array ("Reference image (item from {$this->settings['collectionName']})") : array ('Image (taken from external source)', 'Video (taken from external source)', 'Document'))),
					'filename' => (preg_match ('/^edit/', $action) ? array ('editable' => false,) : array ('type' => 'upload', 'directory' => $this->settings['mediaDirectory'] . $pollenId . '/', 'regexpi' => '^(http|https)://(.*)(jpg|jpeg|gif|png|tif|pdf)')),
					'url' => array ('type' => 'input', /*, 'regexpi' => '^(http|https)://(.*)(jpg|jpeg|gif|png|tif|pdf)', 'description' => 'Must begin http:// or https:// and end with an image file extension', 'retrieval' => $this->settings['mediaDirectory'] . $pollenId . '/' */),
				);
				break;
		}
		
		# Databind the form
		$form->dataBinding (array (
			'database' => $this->settings['database'],
			'table' => $table,
			'lookupFunction' => array ('database', 'lookup'),
			'lookupFunctionParameters' => array ($showKeys = NULL, $orderby = array ('variant', 'subvariant', 'family', 'sculpturing', 'id'), $sort = false, $group = 2),
			'lookupFunctionAppendTemplate' => '<a rel=\"nofollow\" href="' . $this->baseUrl . '/data/%table/" class="noarrow" title="Click here to open a new window for editing these values; then click on refresh." target="_blank"> ...</a>%refresh',
			'data'	=> (!preg_match ('/^add/', $action) ? $data : false),
			'truncate' => false,
			'exclude' => $exclude,
			'attributes' => $attributes,
		));
		
		# Enforce uniqueness across logical groupings
		if ($table == 'pollen') {
			$form->validation ('either', array ('family__JOIN__pollen__family__reserved', 'genus', ));
			$form->validation ('different', array ('form__JOIN__pollen__form__reserved', 'alternativeForm__JOIN__pollen__form__reserved', ));
			$form->validation ('different', array ('primaryApertureConfiguration__JOIN__pollen__aperture__reserved', 'alternativeaApertureConfig1__JOIN__pollen__aperture__reserved', 'alternativeaApertureConfig2__JOIN__pollen__aperture__reserved', 'alternativeaApertureConfig3__JOIN__pollen__aperture__reserved', ));
			$form->validation ('different', array ('primarySculpturingType__JOIN__pollen__sculpturing__reserved', 'alternativeSculpturingType1__JOIN__pollen__sculpturing__reserved', 'alternativeSculpturingType2__JOIN__pollen__sculpturing__reserved', 'alternativeSculpturingType3__JOIN__pollen__sculpturing__reserved', ));
			$form->validation ('different', array ('primaryPolarAxis__JOIN__pollen__polaraxis__reserved', 'alternativePolarAxis1__JOIN__pollen__polaraxis__reserved', ));
			$form->validation ('different', array ('primaryEquatorialDiameter__JOIN__pollen__diameter__reserved', 'alternativeEquatorialDiameter1__JOIN__pollen__diameter__reserved', ));
			$form->validation ('different', array ('features1__JOIN__pollen__features__reserved', 'features2__JOIN__pollen__features__reserved', 'features3__JOIN__pollen__features__reserved', ));
		}
		
		# Additional attributes/validation to the media/materials tables
		if ($table == 'media') {
			$form->validation ('either', array ('filename', 'url'));
		}
		
		# Ensure the record does not already exist by checking against relevant fields
		if (($table == 'pollen') && !preg_match ('/^edit/', $action)) {
			if ($unfinalisedData = $form->getUnfinalisedData ()) {
				$uniqueness['family__JOIN__pollen__family__reserved'] = $unfinalisedData['family__JOIN__pollen__family__reserved'];
				$uniqueness['genus'] = $unfinalisedData['genus'];
				$uniqueness['species'] = $unfinalisedData['species'];
				
				# If copies (i.e. non-uniqueness) are detected, register a user problem
				if ($uniquenessData = $this->databaseConnection->select ($this->settings['database'], $this->settings['table'], $uniqueness, array ('id'))) {
					$copies = array_keys ($uniquenessData);
					$copiesLinks = array ();
					foreach ($copies as $copy) {
						$copiesLinks[] = "<a rel=\"nofollow\" href=\"{$this->baseUrl}/articles/{$copy}/\" target=\"_blank\">{$copy}</a>";
					}
					$form->registerProblem ('duplicate', 'The data seems to be a duplicate record of ' . (count ($copies) == 1 ? 'record: ' : 'records: ') . implode (', ', $copiesLinks));
				}
			}
		}
		
		# Obtain the result
		if ($result = $form->process ($html)) {
			
			# Modifications to submitted data
			if (($table == 'pollen') && preg_match ('/^add/', $action)) {
				unset ($result['default']);
				$result['recordCreation'] = 'NOW()';	// Has to be done manually as MySQL doesn't support both creation & update fields in one table
			}
			
			# Add the pollen ID in
			if ($table == 'media' || $table == 'materials') {
				$result['pollen__JOIN__pollen__pollen__reserved'] = $pollenId;
			}
			
			# Add the residue ID in
			if ($table == 'media') {
				$result['residue'] = $materialId;
			}
			
			# Deal with uploaded files when adding; prefer upload over direct retrieval
			if (preg_match ('/^add/', $action)) {
				if ($table == 'media') {
					if (isSet ($result['filename'][0]) && !empty ($result['filename'][0])) {
						$result['filename'] = (isSet ($result['filename'][0]) ? $result['filename'][0] : NULL);
					} elseif ($result['url']) {
						$retrieval = $this->settings['mediaDirectory'] . $pollenId . '/';
						$saveLocation = $retrieval . basename ($result['url']);
						#!# This next line should be replaced with some variant of urlencode that doesn't swallow / or :
						$elementValue = str_replace (' ', '%20', $result['url']);
						if (!$fileContents = file_get_contents ($result['url'])) {
							$html .= "<p>URL retrieval failed; possibly the URL you quoted does not exist, or the server is blocking file downloads somehow.</p>";
						} else {
							file_put_contents ($saveLocation, $fileContents);
						}
						$result['filename'] = basename ($result['url']);
					}
				}
			}
			
			# Insert the new item in the database
			#!# Use a proper update when updating rather than insert
			if (!$this->databaseConnection->insert ($this->settings['database'], $table, $result, true)) {
				$html .= ("\n<p>There was a problem " . (preg_match ('/^add/', $action) ? 'inserting the record into' : 'updating the record in') . ' the database.</p>');
			} else {
				if (($action == 'add') && ($table == 'pollen')) {
					$lastInsertId = $this->databaseConnection->getLatestId ();
					$refreshTo = $this->baseUrl . '/articles/' . $lastInsertId . '/';
				} else {
					$refreshTo = dirname ($_SERVER['REQUEST_URI']) . "#{$anchor}";
				}
				$html  = ("\n<p><strong>The data was successfully updated.</strong> Refreshing to <a href=\"{$refreshTo}\">the updated page</a> ...</p>");
				header ("Location: https://{$_SERVER['SERVER_NAME']}{$refreshTo}");
			}
		}
		
		# Return the HTML
		return $html;
	}
	
	
	# Function for public display of a record
	private function displayRecord ($article, $data, $fields, $fullView, $displayEmpty = false)
	{
		# Start the HTML
		$html = '';
		
		# Remove data that should not be visible
		unset ($data['photograph']);
		unset ($data['location']);
		
		# Get the table headings
		$headings = $this->databaseConnection->getHeadings ($this->settings['database'], $this->settings['table'], $fields);
		
		# Cache the URLs field specially
		$urls = $data['urls'];
		
		# Convert the joins
		$dataset = array ($data);
		$dataset = $this->databaseConnection->substituteJoinedData ($dataset, $this->settings['database'], false);
		$data = $dataset[0];
		
		# Convert two fields to richtext view
		#!# Ideally these fields should be set as a different SQL type which ultimateForm then picks up
		$data['references'] = html_entity_decode ($data['references']);
		$data['notes'] = html_entity_decode ($data['notes']);
		
		# Specific conversions
		$data['urls'] = application::urlReferencesBox ($urls);
		if (!$fullView) {
			unset ($data['recordCreation'], $data['lastModified'], $data['userCreator']);
		}
		
		# Clean the data
		if (!$this->userIsAdministrator) {
			unset ($data['userCreator']);
		}
		
		# Show the data
		$html .= "\n" . application::htmlTableKeyed ($data, $headings, ($displayEmpty ? '<em class="comment">(Unknown)</em>' : true), 'lines regulated', $allowHtml = true);
		
		# Return the HTML
		return $html;
	}
	
	
	# Function to create media data HTML
	private function mediaDataHtml ($action, $mediaItem, $key, $article, $mediaFields, $limitFields, $materialId = false)
	{
		# Determine if a material is being edited
		$editMedia = (($action == 'editmedia' && isSet ($_GET['record']) && $_GET['record'] == $key) ? $key : false);
		
		# Compile the HTML
		$html  = "\n<div class=\"media\">";
		$html .= "\n<h4 id=\"media{$key}\"><img src=\"/images/icons/picture.png\" alt=\"Media\" class=\"icon\" /> " . htmlspecialchars ($mediaItem['shortDescription']) . '</h4>';
		$html .= "\n<ul class=\"actions noprint\">";
		if ($editMedia) {
			$html .= "<li><a rel=\"nofollow\" href=\"{$this->baseUrl}/articles/{$article}/#media{$key}\"><img src=\"/images/icons/picture_delete.png\" alt=\"Cancel\" /> Cancel editing</a></li>";
		} else {
			$html .= "<li><a rel=\"nofollow\" href=\"{$this->baseUrl}/articles/{$article}/editmedia.html?record={$key}#media{$key}\"><img src=\"/images/icons/picture_edit.png\" alt=\"Edit\" /> Edit this media</a></li>";
			$html .= "<li><a rel=\"nofollow\" target=\"_blank\" href=\"{$this->baseUrl}/data/media/{$key}/delete.html\"><img src=\"/images/icons/cross.png\" alt=\"Delete\" /> Delete this media&hellip;</a></li>";
		}
		$html .= "\n</ul>";
		
		if ($editMedia) {
			$html .= $this->editableRegion ($article, $action, 'media', $mediaItem, "media{$key}", $materialId);
		} else {
			# Remove unwanted fields
			unset ($mediaItem['id']);
			unset ($mediaItem['pollen__JOIN__pollen__pollen__reserved']);
			unset ($mediaItem['shortDescription']);
			$copyrightStatus = $mediaItem['copyrightStatus'];
			unset ($mediaItem['copyrightStatus']);
			if (!$this->userIsAdministrator) {unset ($mediaItem['privateNotes']);}
			
			# Remove unwanted fields if in (default) view limiting mode
			if ($limitFields) {
				foreach ($mediaItem as $field => $value) {
					if (!in_array ($field, $limitFields)) {
						unset ($mediaItem[$field]);
					}
				}
			}
			
			# Lookup joins
			$imageHtml = '<p class="nullimage">No image available</p>';
			if ($mediaItem['filename']) {
				if ($this->userIsAdministrator || $copyrightStatus == 'Permission granted to reproduce') {
					if (preg_match ('/.(jpg|jpeg|gif|tif|tiff|png)$/i', strtolower ($mediaItem['filename']))) {	// Don't link non-images
						$imageLocation = "{$this->baseUrl}/media/{$article}/" . rawurlencode ($mediaItem['filename']);
						$imageHtml = "<a href=\"{$imageLocation}\" class=\"noarrow\" target=\"_blank\"><img src=\"{$this->settings['imageGenerationStub']}?{$this->settings['width']},{$imageLocation}\" alt=\"Image\" border=\"0\" width=\"{$this->settings['width']}\" /></a>";
						
					}
				} else {
					$imageHtml = '<p class="nullimage">Copyright restrictions prevent this image being displayed.</p>';
				}
			}
			
			# Complete the left side
			$leftHtml  = $imageHtml;
			unset ($mediaItem['filename']);
			
			# Reformat certain fields
			$mediaItem['publicNotes']  = application::formatTextBlock ($mediaItem['publicNotes']);
			
			# Cache certain fields
			$source = $mediaItem['url'];
			unset ($mediaItem['url']);
			
			# Compile the right side of the table
			$rightHtml = array ();
			if ($limitFields) {
				$rightHtml[] = "\n<p class=\"notes\">" . $mediaItem['publicNotes'] . '</p>';
			} else {
				#!# Fix alignment of publicNotes
				#!# Not clear that this code is ever used
				$mediaHeadings = $this->databaseConnection->getHeadings ($this->settings['database'], 'media', $mediaFields /* Supplying the fields merely saves having to get them again */);
				$rightHtml[] = application::htmlTableKeyed ($mediaItem, $mediaHeadings, $omitEmpty = false, $class = 'lines', $allowHtml = false, $showColons = true, $dlFormat = false, $addCellClasses = true);
			}
			$rightHtml[] = "\n<p class=\"noprint smaller source\"><a href=\"{$source}\" target=\"_blank\" title=\"Link to source image\">[Link]</a></p>";
			
			# Compile the table
			$mediaHtmlTable[$leftHtml] = implode ('', $rightHtml);
			
			# Add the HTML
			$html .= application::htmlTableKeyed ($mediaHtmlTable, false, $omitEmpty = true, $class = 'lines media regulated', $allowHtml = true, $showColons = false);
		}
		$html .= "\n</div>";
		
		# Return the HTML
		return $html;
	}
	
	
	# Function to get article data
	private function getArticleData ($article, $photograph = false)
	{
		# Define whether the article number is syntactically valid
		if (!ctype_digit ($article)) {
			application::sendHeader (404);
			include ($this->settings['page404']);
			return false;
		}
		
		# Get the data
		if (!$record = $this->databaseConnection->selectOne ($this->settings['database'], $this->settings['table'], array ('id' => $article))) {
			application::sendHeader (404);
			include ($this->settings['page404']);
			return false;
		}
		
		# Clean text
		#!# This should be enabled ONLY conditionally if in viewing mode but NOT editing mode
		// $record = application::cleanText ($record);
		
		# Return the record
		return $record;
	}
	
	
	# Function to get article data
	private function getArticleMediaData ($article)
	{
		# Define whether the article number is syntactically valid
		if (!ctype_digit ($article)) {
			return array ();
		}
		
		# Construct a query to get the full data
		$data = $this->databaseConnection->select ($this->settings['database'], 'media', array ('pollen__JOIN__pollen__pollen__reserved' => $article));
		
		# Return the record
		return $data;
	}
	
	
	# Function to provide a search facility
	#!# Unfinished, as it calls articles () which then redirects
	public function search ()
	{
		# Determine any default
		$default = (isSet ($_GET['item']) ? $_GET['item'] : false);
		
		# Start the HTML
		$html  = '';
		
		# Create a new form
		$form = new form (array (
			'displayRestrictions' => false,
			'display' => 'template',
			'displayTemplate' => '{search} {[[PROBLEMS]]} {[[SUBMIT]]}<br />{wildcard}',
			'requiredFieldIndicator' => false,
			'submitButtonText' => 'Search!',
			'formCompleteText' => false,
			'reappear' => true,
			'escapeOutput' => true,
			'submitTo' => $this->baseUrl . '/search/',
		));
		$form->input (array (
			'name'		=> 'search',
			'title'		=> 'Search',
			'required'	=> true,
			'default' 	=> $default,
		));
		$form->checkboxes (array (
			'name'		=> 'wildcard',
			'title'		=> 'Allow partial name searching',
			'values'	=> array ('wildcard' => 'Allow partial name searching'),
			'default'	=> array ('wildcard'),
		));
		if (!$result = $form->process ($html)) {
			echo $html;
			return;
		}
		
		# Define the restriction, surrounding the search term with a word-boundary limitation
		$restrictionSql = "
			AND (
			   specimenName REGEXP :searchQuery
			OR age          REGEXP :searchQuery
			OR siteOfOrigin REGEXP :searchQuery
			OR accessionCode = :search
			)
		";
		$preparedStatementValues = array (
			'searchQuery'	=> ($result['wildcard']['wildcard'] ? '\b' . $result['search'] . '\b' : $result['search']),
			'search'		=> $result['search'],
		);
		
		# Get the HTML
		$html = $this->articles ($restrictionSql, $preparedStatementValues);
		
		# Show the HTML
		echo $html;
	}
	
	
	# Admin editing section, substantially delegated to the sinenomine editing component
	public function editing ($attributes = array (), $deny = false, $sinenomineExtraSettings = array ())
	{
		# Add specific functionality if a table is defined for editing
		if (isSet ($_GET['table']) && isSet ($_GET['do']) && !empty ($_GET['do'])) {
			if (in_array ($_GET['table'], array ('media', 'materials'))) {
				$lookupFunctionParameters = array ($showKeys = true, $orderby = false, $sort = true, $group = false);
			}
		}
		
		# Define sinenomine settings
		$sinenomineExtraSettings = array (
			'lookupFunctionParameters' => (isSet ($lookupFunctionParameters) ? $lookupFunctionParameters : false),
			'headingLevel' => 2,	#!# Should be set in FCA
		);
		
		# Set attributes
		#!# Incomplete and untested - see editing in main section, whose attributes should be used
		$attributes = array (
			#!# Use of %id not yet supported for directory
			array ($this->settings['database'], 'media', 'filename', array ('directory' => $this->settings['mediaDirectory'] . '%id/', 'regexpi' => '^(http|https)://(.*)(jpg|jpeg|gif|png|tif|pdf)')),
		);
		
		# Hand off to the default editor, which will echo the HTML
		parent::editing ($attributes, $deny = false /* i.e. administrators table */, $sinenomineExtraSettings);
	}
}

?>
