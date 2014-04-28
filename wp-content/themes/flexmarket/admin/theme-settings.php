<?php
add_action('init','m413_options');

if (!function_exists('m413_options')) {
	function m413_options(){
		$themename = 'flexmarket';
		$shortname = "mpt";  // you need to replace this with your own theme name so you avoid naming collisions
		global $mbb_options;  // add all options to an array
		$mbb_options = get_option('m413_options');

		$mbb_pages = array(); // get all wp pages and view them as an array
		$mbb_pages_obj = get_pages('sort_column=post_parent,menu_order');
		foreach ($mbb_pages_obj as $mbb_page) {
			$mbb_pages[$mbb_page->ID] = $mbb_page->post_name; }
		$mbb_pages_tmp = array_unshift($mbb_pages, "Select a page:");

		$mbb_posts = array(); // get all wp posts and view them as an array
		$mbb_posts_obj = get_posts();
		foreach ($mbb_posts_obj as $mbb_post){
			$mbb_posts[$mbb_post->ID] = $mbb_post->post_title; }
		$mbb_posts_tmp = array_unshift($mbb_posts, "Select a post:");

		$mbb_categories = array(); // get all wp categories and view them as an array
		$mbb_categories_obj = get_categories('hide_empty=0');
		foreach ($mbb_categories_obj as $mbb_cat) {
			$mbb_categories[$mbb_cat->cat_ID] = $mbb_cat->cat_name;}
		$mbb_categories_tmp = array_unshift($mbb_categories, "Select a category:");

		$sample_array = array("1","2","3","4","5");  // sample for testing
		$sample_advanced_array = array("image" => "The Image","post" => "The Post"); // sample for testing

		$sampleurl =  get_template_directory_uri() . '/admin/images/'; // where saving images
		$themefolder =  get_template_directory_uri(); // theme directory
/*
		function m413_recognized_font_faces() {
			$default = array(
				'arial'     => 'Arial',
				'verdana'   => 'Verdana, Geneva',
				'trebuchet' => 'Trebuchet',
				'georgia'   => 'Georgia',
				'times'     => 'Times New Roman',
				'tahoma'    => 'Tahoma, Geneva',
				'palatino'  => 'Palatino',
				'helvetica' => 'Helvetica*'
				);
			return apply_filters( 'm413_recognized_font_faces', $default );
		}
		function m413_recognized_font_styles() {
			$default = array(
				'normal'      => __('Normal', 'flexmarket'),
				'italic'      => __('Italic', 'flexmarket'),
				'bold'        => __('Bold', 'flexmarket'),
				'bold italic' => __('Bold Italic', 'flexmarket')
				);
			return apply_filters( 'm413_recognized_font_styles', $default );
		}
		function m413_recognized_font_sizes() {
			$sizes = range( 9, 71 );
			$sizes = apply_filters( 'm413_recognized_font_sizes', $sizes );
			$sizes = array_map( 'absint', $sizes );
			return $sizes;
		}
*/

		$mpt_google_web_fonts = array(
			'abeezee' => 'ABeeZee',
			'abel' => 'Abel',
			'abrilfatface' => 'Abril Fatface',
			'aclonica' => 'Aclonica',
			'acme' => 'Acme',
			'actor' => 'Actor',
			'adamina' => 'Adamina',
			'adventpro' => 'Advent Pro',
			'aguafinascript' => 'Aguafina Script',
			'akronim' => 'Akronim',
			'aladin' => 'Aladin',
			'aldrich' => 'Aldrich',
			'alegreya' => 'Alegreya',
			'alegreyasc' => 'Alegreya SC',
			'alexbrush' => 'Alex Brush',
			'alfaslabone' => 'Alfa Slab One',
			'alice' => 'Alice',
			'alike' => 'Alike',
			'alikeangular' => 'Alike Angular',
			'allan' => 'Allan',
			'allerta' => 'Allerta',
			'allertastencil' => 'Allerta Stencil',
			'allura' => 'Allura',
			'almendra' => 'Almendra',
			'almendrasc' => 'Almendra SC',
			'amarante' => 'Amarante',
			'amaranth' => 'Amaranth',
			'amaticsc' => 'Amatic SC',
			'amethysta' => 'Amethysta',
			'anaheim' => 'Anaheim',
			'andada' => 'Andada',
			'andika' => 'Andika',
			'angkor' => 'Angkor',
			'annieuseyourtelescope' => 'Annie Use Your Telescope',
			'anonymouspro' => 'Anonymous Pro',
			'antic' => 'Antic',
			'anticdidone' => 'Antic Didone',
			'anticslab' => 'Antic Slab',
			'anton' => 'Anton',
			'arapey' => 'Arapey',
			'arbutus' => 'Arbutus',
			'arbutusslab' => 'Arbutus Slab',
			'architectsdaughter' => 'Architects Daughter',
			'archivoblack' => 'Archivo Black',
			'archivonarrow' => 'Archivo Narrow',
			'arimo' => 'Arimo',
			'arizonia' => 'Arizonia',
			'armata' => 'Armata',
			'artifika' => 'Artifika',
			'arvo' => 'Arvo',
			'asap' => 'Asap',
			'asset' => 'Asset',
			'astloch' => 'Astloch',
			'asul' => 'Asul',
			'atomicage' => 'Atomic Age',
			'aubrey' => 'Aubrey',
			'audiowide' => 'Audiowide',
			'autourone' => 'Autour One',
			'average' => 'Average',
			'averagesans' => 'Average Sans',
			'averiagruesalibre' => 'Averia Gruesa Libre',
			'averialibre' => 'Averia Libre',
			'averiasanslibre' => 'Averia Sans Libre',
			'averiaseriflibre' => 'Averia Serif Libre',
			'badscript' => 'Bad Script',
			'balthazar' => 'Balthazar',
			'bangers' => 'Bangers',
			'basic' => 'Basic',
			'battambang' => 'Battambang',
			'baumans' => 'Baumans',
			'bayon' => 'Bayon',
			'belgrano' => 'Belgrano',
			'belleza' => 'Belleza',
			'benchnine' => 'BenchNine',
			'bentham' => 'Bentham',
			'berkshireswash' => 'Berkshire Swash',
			'bevan' => 'Bevan',
			'bigshotone' => 'Bigshot One',
			'bilbo' => 'Bilbo',
			'bilboswashcaps' => 'Bilbo Swash Caps',
			'bitter' => 'Bitter',
			'blackopsone' => 'Black Ops One',
			'bokor' => 'Bokor',
			'bonbon' => 'Bonbon',
			'boogaloo' => 'Boogaloo',
			'bowlbyone' => 'Bowlby One',
			'bowlbyonesc' => 'Bowlby One SC',
			'brawler' => 'Brawler',
			'breeserif' => 'Bree Serif',
			'bubblegumsans' => 'Bubblegum Sans',
			'bubblerone' => 'Bubbler One',
			'buda' => 'Buda',
			'buenard' => 'Buenard',
			'butcherman' => 'Butcherman',
			'butterflykids' => 'Butterfly Kids',
			'cabin' => 'Cabin',
			'cabincondensed' => 'Cabin Condensed',
			'cabinsketch' => 'Cabin Sketch',
			'caesardressing' => 'Caesar Dressing',
			'cagliostro' => 'Cagliostro',
			'calligraffitti' => 'Calligraffitti',
			'cambo' => 'Cambo',
			'candal' => 'Candal',
			'cantarell' => 'Cantarell',
			'cantataone' => 'Cantata One',
			'cantoraone' => 'Cantora One',
			'capriola' => 'Capriola',
			'cardo' => 'Cardo',
			'carme' => 'Carme',
			'carroisgothic' => 'Carrois Gothic',
			'carroisgothicsc' => 'Carrois Gothic SC',
			'carterone' => 'Carter One',
			'caudex' => 'Caudex',
			'cedarvillecursive' => 'Cedarville Cursive',
			'cevicheone' => 'Ceviche One',
			'changaone' => 'Changa One',
			'chango' => 'Chango',
			'chauphilomeneone' => 'Chau Philomene One',
			'chelaone' => 'Chela One',
			'chelseamarket' => 'Chelsea Market',
			'chenla' => 'Chenla',
			'cherrycreamsoda' => 'Cherry Cream Soda',
			'cherryswash' => 'Cherry Swash',
			'chewy' => 'Chewy',
			'chicle' => 'Chicle',
			'chivo' => 'Chivo',
			'cinzel' => 'Cinzel',
			'cinzeldecorative' => 'Cinzel Decorative',
			'coda' => 'Coda',
			'codacaption' => 'Coda Caption',
			'codystar' => 'Codystar',
			'combo' => 'Combo',
			'comfortaa' => 'Comfortaa',
			'comingsoon' => 'Coming Soon',
			'concertone' => 'Concert One',
			'condiment' => 'Condiment',
			'content' => 'Content',
			'contrailone' => 'Contrail One',
			'convergence' => 'Convergence',
			'cookie' => 'Cookie',
			'copse' => 'Copse',
			'corben' => 'Corben',
			'courgette' => 'Courgette',
			'cousine' => 'Cousine',
			'coustard' => 'Coustard',
			'coveredbyyourgrace' => 'Covered By Your Grace',
			'craftygirls' => 'Crafty Girls',
			'creepster' => 'Creepster',
			'creteround' => 'Crete Round',
			'crimsontext' => 'Crimson Text',
			'crushed' => 'Crushed',
			'cuprum' => 'Cuprum',
			'cutive' => 'Cutive',
			'cutivemono' => 'Cutive Mono',
			'damion' => 'Damion',
			'dancingscript' => 'Dancing Script',
			'dangrek' => 'Dangrek',
			'dawningofanew' => 'Dawning of a New Day',
			'daysone' => 'Days One',
			'delius' => 'Delius',
			'deliusswashcaps' => 'Delius Swash Caps',
			'deliusunicase' => 'Delius Unicase',
			'dellarespira' => 'Della Respira',
			'devonshire' => 'Devonshire',
			'didactgothic' => 'Didact Gothic',
			'diplomata' => 'Diplomata',
			'diplomatasc' => 'Diplomata SC',
			'doppioone' => 'Doppio One',
			'dorsa' => 'Dorsa',
			'dosis' => 'Dosis',
			'drsugiyama' => 'Dr Sugiyama',
			'droidsans' => 'Droid Sans',
			'droidsansmono' => 'Droid Sans Mono',
			'droidserif' => 'Droid Serif',
			'durusans' => 'Duru Sans',
			'dynalight' => 'Dynalight',
			'ebgaramond' => 'EB Garamond',
			'eaglelake' => 'Eagle Lake',
			'eater' => 'Eater',
			'economica' => 'Economica',
			'electrolize' => 'Electrolize',
			'emblemaone' => 'Emblema One',
			'emilyscandy' => 'Emilys Candy',
			'engagement' => 'Engagement',
			'enriqueta' => 'Enriqueta',
			'ericaone' => 'Erica One',
			'esteban' => 'Esteban',
			'euphoriascript' => 'Euphoria Script',
			'ewert' => 'Ewert',
			'exo' => 'Exo',
			'expletussans' => 'Expletus Sans',
			'fanwoodtext' => 'Fanwood Text',
			'fascinate' => 'Fascinate',
			'fascinateinline' => 'Fascinate Inline',
			'fasterone' => 'Faster One',
			'fasthand' => 'Fasthand',
			'federant' => 'Federant',
			'federo' => 'Federo',
			'felipa' => 'Felipa',
			'fenix' => 'Fenix',
			'fingerpaint' => 'Finger Paint',
			'fjordone' => 'Fjord One',
			'flamenco' => 'Flamenco',
			'flavors' => 'Flavors',
			'fondamento' => 'Fondamento',
			'fontdinerswanky' => 'Fontdiner Swanky',
			'forum' => 'Forum',
			'francoisone' => 'Francois One',
			'frederickathegreat' => 'Fredericka the Great',
			'fredokaone' => 'Fredoka One',
			'freehand' => 'Freehand',
			'fresca' => 'Fresca',
			'frijole' => 'Frijole',
			'fugazone' => 'Fugaz One',
			'gfsdidot' => 'GFS Didot',
			'gfsneohellenic' => 'GFS Neohellenic',
			'galdeano' => 'Galdeano',
			'galindo' => 'Galindo',
			'gentiumbasic' => 'Gentium Basic',
			'gentiumbookbasic' => 'Gentium Book Basic',
			'geo' => 'Geo',
			'geostar' => 'Geostar',
			'geostarfill' => 'Geostar Fill',
			'germaniaone' => 'Germania One',
			'giveyouglory' => 'Give You Glory',
			'glassantiqua' => 'Glass Antiqua',
			'glegoo' => 'Glegoo',
			'gloriahallelujah' => 'Gloria Hallelujah',
			'goblinone' => 'Goblin One',
			'gochihand' => 'Gochi Hand',
			'gorditas' => 'Gorditas',
			'goudybookletter1911' => 'Goudy Bookletter 1911',
			'graduate' => 'Graduate',
			'gravitasone' => 'Gravitas One',
			'greatvibes' => 'Great Vibes',
			'griffy' => 'Griffy',
			'gruppo' => 'Gruppo',
			'gudea' => 'Gudea',
			'habibi' => 'Habibi',
			'hammersmithone' => 'Hammersmith One',
			'handlee' => 'Handlee',
			'hanuman' => 'Hanuman',
			'happymonkey' => 'Happy Monkey',
			'headlandone' => 'Headland One',
			'hennypenny' => 'Henny Penny',
			'herrvonmuellerhoff' => 'Herr Von Muellerhoff',
			'holtwoodonesc' => 'Holtwood One SC',
			'homemadeapple' => 'Homemade Apple',
			'homenaje' => 'Homenaje',
			'imfelldwpica' => 'IM Fell DW Pica',
			'imfelldwpica' => 'IM Fell DW Pica SC',
			'imfelldoublepica' => 'IM Fell Double Pica',
			'imfelldoublepica' => 'IM Fell Double Pica SC',
			'imfellenglish' => 'IM Fell English',
			'imfellenglishsc' => 'IM Fell English SC',
			'imfellfrenchcanon' => 'IM Fell French Canon',
			'imfellfrenchcanon' => 'IM Fell French Canon SC',
			'imfellgreatprimer' => 'IM Fell Great Primer',
			'imfellgreatprimer' => 'IM Fell Great Primer SC',
			'iceberg' => 'Iceberg',
			'iceland' => 'Iceland',
			'imprima' => 'Imprima',
			'inconsolata' => 'Inconsolata',
			'inder' => 'Inder',
			'indieflower' => 'Indie Flower',
			'inika' => 'Inika',
			'irishgrover' => 'Irish Grover',
			'istokweb' => 'Istok Web',
			'italiana' => 'Italiana',
			'italianno' => 'Italianno',
			'jacquesfrancois' => 'Jacques Francois',
			'jacquesfrancoisshadow' => 'Jacques Francois Shadow',
			'jimnightshade' => 'Jim Nightshade',
			'jockeyone' => 'Jockey One',
			'jollylodger' => 'Jolly Lodger',
			'josefinsans' => 'Josefin Sans',
			'josefinslab' => 'Josefin Slab',
			'judson' => 'Judson',
			'julee' => 'Julee',
			'juliussansone' => 'Julius Sans One',
			'junge' => 'Junge',
			'jura' => 'Jura',
			'justanotherhand' => 'Just Another Hand',
			'justmeagaindown' => 'Just Me Again Down Here',
			'kameron' => 'Kameron',
			'karla' => 'Karla',
			'kaushanscript' => 'Kaushan Script',
			'kellyslab' => 'Kelly Slab',
			'kenia' => 'Kenia',
			'khmer' => 'Khmer',
			'kiteone' => 'Kite One',
			'knewave' => 'Knewave',
			'kottaone' => 'Kotta One',
			'koulen' => 'Koulen',
			'kranky' => 'Kranky',
			'kreon' => 'Kreon',
			'kristi' => 'Kristi',
			'kronaone' => 'Krona One',
			'labelleaurore' => 'La Belle Aurore',
			'lancelot' => 'Lancelot',
			'lato' => 'Lato',
			'leaguescript' => 'League Script',
			'leckerlione' => 'Leckerli One',
			'ledger' => 'Ledger',
			'lekton' => 'Lekton',
			'lemon' => 'Lemon',
			'lifesavers' => 'Life Savers',
			'lilitaone' => 'Lilita One',
			'limelight' => 'Limelight',
			'lindenhill' => 'Linden Hill',
			'lobster' => 'Lobster',
			'lobstertwo' => 'Lobster Two',
			'londrinaoutline' => 'Londrina Outline',
			'londrinashadow' => 'Londrina Shadow',
			'londrinasketch' => 'Londrina Sketch',
			'londrinasolid' => 'Londrina Solid',
			'lora' => 'Lora',
			'loveyalikea' => 'Love Ya Like A Sister',
			'lovedbytheking' => 'Loved by the King',
			'loversquarrel' => 'Lovers Quarrel',
			'luckiestguy' => 'Luckiest Guy',
			'lusitana' => 'Lusitana',
			'lustria' => 'Lustria',
			'macondo' => 'Macondo',
			'macondoswashcaps' => 'Macondo Swash Caps',
			'magra' => 'Magra',
			'maidenorange' => 'Maiden Orange',
			'mako' => 'Mako',
			'marcellus' => 'Marcellus',
			'marcellussc' => 'Marcellus SC',
			'marckscript' => 'Marck Script',
			'markoone' => 'Marko One',
			'marmelad' => 'Marmelad',
			'marvel' => 'Marvel',
			'mate' => 'Mate',
			'matesc' => 'Mate SC',
			'mavenpro' => 'Maven Pro',
			'mclaren' => 'McLaren',
			'meddon' => 'Meddon',
			'medievalsharp' => 'MedievalSharp',
			'medulaone' => 'Medula One',
			'megrim' => 'Megrim',
			'meiescript' => 'Meie Script',
			'meriendaone' => 'Merienda One',
			'merriweather' => 'Merriweather',
			'metal' => 'Metal',
			'metalmania' => 'Metal Mania',
			'metamorphous' => 'Metamorphous',
			'metrophobic' => 'Metrophobic',
			'michroma' => 'Michroma',
			'miltonian' => 'Miltonian',
			'miltoniantattoo' => 'Miltonian Tattoo',
			'miniver' => 'Miniver',
			'missfajardose' => 'Miss Fajardose',
			'modernantiqua' => 'Modern Antiqua',
			'molengo' => 'Molengo',
			'molle' => 'Molle',
			'monofett' => 'Monofett',
			'monoton' => 'Monoton',
			'monsieurladoulaise' => 'Monsieur La Doulaise',
			'montaga' => 'Montaga',
			'montez' => 'Montez',
			'montserrat' => 'Montserrat',
			'montserratalternates' => 'Montserrat Alternates',
			'montserratsubrayada' => 'Montserrat Subrayada',
			'moul' => 'Moul',
			'moulpali' => 'Moulpali',
			'mountainsofchristmas' => 'Mountains of Christmas',
			'mrbedfort' => 'Mr Bedfort',
			'mrdafoe' => 'Mr Dafoe',
			'mrdehaviland' => 'Mr De Haviland',
			'mrssaintdelafield' => 'Mrs Saint Delafield',
			'mrssheppards' => 'Mrs Sheppards',
			'muli' => 'Muli',
			'mysteryquest' => 'Mystery Quest',
			'neucha' => 'Neucha',
			'neuton' => 'Neuton',
			'newscycle' => 'News Cycle',
			'niconne' => 'Niconne',
			'nixieone' => 'Nixie One',
			'nobile' => 'Nobile',
			'nokora' => 'Nokora',
			'norican' => 'Norican',
			'nosifer' => 'Nosifer',
			'nothingyoucoulddo' => 'Nothing You Could Do',
			'noticiatext' => 'Noticia Text',
			'novacut' => 'Nova Cut',
			'novaflat' => 'Nova Flat',
			'novamono' => 'Nova Mono',
			'novaoval' => 'Nova Oval',
			'novaround' => 'Nova Round',
			'novascript' => 'Nova Script',
			'novaslim' => 'Nova Slim',
			'novasquare' => 'Nova Square',
			'numans' => 'Numans',
			'nunito' => 'Nunito',
			'odormeanchey' => 'Odor Mean Chey',
			'offside' => 'Offside',
			'oldstandardtt' => 'Old Standard TT',
			'oldenburg' => 'Oldenburg',
			'oleoscript' => 'Oleo Script',
			'opensans' => 'Open Sans',
			'opensanscondensed' => 'Open Sans Condensed',
			'oranienbaum' => 'Oranienbaum',
			'orbitron' => 'Orbitron',
			'oregano' => 'Oregano',
			'orienta' => 'Orienta',
			'originalsurfer' => 'Original Surfer',
			'oswald' => 'Oswald',
			'overtherainbow' => 'Over the Rainbow',
			'overlock' => 'Overlock',
			'overlocksc' => 'Overlock SC',
			'ovo' => 'Ovo',
			'oxygen' => 'Oxygen',
			'oxygenmono' => 'Oxygen Mono',
			'ptmono' => 'PT Mono',
			'ptsans' => 'PT Sans',
			'ptsanscaption' => 'PT Sans Caption',
			'ptsansnarrow' => 'PT Sans Narrow',
			'ptserif' => 'PT Serif',
			'ptserifcaption' => 'PT Serif Caption',
			'pacifico' => 'Pacifico',
			'paprika' => 'Paprika',
			'parisienne' => 'Parisienne',
			'passeroone' => 'Passero One',
			'passionone' => 'Passion One',
			'patrickhand' => 'Patrick Hand',
			'patuaone' => 'Patua One',
			'paytoneone' => 'Paytone One',
			'peralta' => 'Peralta',
			'permanentmarker' => 'Permanent Marker',
			'petitformalscript' => 'Petit Formal Script',
			'petrona' => 'Petrona',
			'philosopher' => 'Philosopher',
			'piedra' => 'Piedra',
			'pinyonscript' => 'Pinyon Script',
			'plaster' => 'Plaster',
			'play' => 'Play',
			'playball' => 'Playball',
			'playfairdisplay' => 'Playfair Display',
			'playfairdisplaysc' => 'Playfair Display SC',
			'podkova' => 'Podkova',
			'poiretone' => 'Poiret One',
			'pollerone' => 'Poller One',
			'poly' => 'Poly',
			'pompiere' => 'Pompiere',
			'pontanosans' => 'Pontano Sans',
			'portlligatsans' => 'Port Lligat Sans',
			'portlligatslab' => 'Port Lligat Slab',
			'prata' => 'Prata',
			'preahvihear' => 'Preahvihear',
			'pressstart2p' => 'Press Start 2P',
			'princesssofia' => 'Princess Sofia',
			'prociono' => 'Prociono',
			'prostoone' => 'Prosto One',
			'puritan' => 'Puritan',
			'quando' => 'Quando',
			'quantico' => 'Quantico',
			'quattrocento' => 'Quattrocento',
			'quattrocentosans' => 'Quattrocento Sans',
			'questrial' => 'Questrial',
			'quicksand' => 'Quicksand',
			'qwigley' => 'Qwigley',
			'racingsansone' => 'Racing Sans One',
			'radley' => 'Radley',
			'raleway' => 'Raleway',
			'ralewaydots' => 'Raleway Dots',
			'rammettoone' => 'Rammetto One',
			'ranchers' => 'Ranchers',
			'rancho' => 'Rancho',
			'rationale' => 'Rationale',
			'redressed' => 'Redressed',
			'reeniebeanie' => 'Reenie Beanie',
			'revalia' => 'Revalia',
			'ribeye' => 'Ribeye',
			'ribeyemarrow' => 'Ribeye Marrow',
			'righteous' => 'Righteous',
			'rochester' => 'Rochester',
			'rocksalt' => 'Rock Salt',
			'rokkitt' => 'Rokkitt',
			'romanesco' => 'Romanesco',
			'ropasans' => 'Ropa Sans',
			'rosario' => 'Rosario',
			'rosarivo' => 'Rosarivo',
			'rougescript' => 'Rouge Script',
			'ruda' => 'Ruda',
			'rugeboogie' => 'Ruge Boogie',
			'ruluko' => 'Ruluko',
			'ruslandisplay' => 'Ruslan Display',
			'russoone' => 'Russo One',
			'ruthie' => 'Ruthie',
			'rye' => 'Rye',
			'sail' => 'Sail',
			'salsa' => 'Salsa',
			'sanchez' => 'Sanchez',
			'sancreek' => 'Sancreek',
			'sansitaone' => 'Sansita One',
			'sarina' => 'Sarina',
			'satisfy' => 'Satisfy',
			'scada' => 'Scada',
			'schoolbell' => 'Schoolbell',
			'seaweedscript' => 'Seaweed Script',
			'sevillana' => 'Sevillana',
			'seymourone' => 'Seymour One',
			'shadowsintolight' => 'Shadows Into Light',
			'shadowsintolighttwo' => 'Shadows Into Light Two',
			'shanti' => 'Shanti',
			'share' => 'Share',
			'sharetech' => 'Share Tech',
			'sharetechmono' => 'Share Tech Mono',
			'shojumaru' => 'Shojumaru',
			'shortstack' => 'Short Stack',
			'siemreap' => 'Siemreap',
			'sigmarone' => 'Sigmar One',
			'signika' => 'Signika',
			'signikanegative' => 'Signika Negative',
			'simonetta' => 'Simonetta',
			'sirinstencil' => 'Sirin Stencil',
			'sixcaps' => 'Six Caps',
			'skranji' => 'Skranji',
			'slackey' => 'Slackey',
			'smokum' => 'Smokum',
			'smythe' => 'Smythe',
			'sniglet' => 'Sniglet',
			'snippet' => 'Snippet',
			'sofadione' => 'Sofadi One',
			'sofia' => 'Sofia',
			'sonsieone' => 'Sonsie One',
			'sortsmillgoudy' => 'Sorts Mill Goudy',
			'sourcecodepro' => 'Source Code Pro',
			'sourcesanspro' => 'Source Sans Pro',
			'specialelite' => 'Special Elite',
			'spicyrice' => 'Spicy Rice',
			'spinnaker' => 'Spinnaker',
			'spirax' => 'Spirax',
			'squadaone' => 'Squada One',
			'stalinistone' => 'Stalinist One',
			'stardosstencil' => 'Stardos Stencil',
			'stintultracondensed' => 'Stint Ultra Condensed',
			'stintultraexpanded' => 'Stint Ultra Expanded',
			'stoke' => 'Stoke',
			'strait' => 'Strait',
			'sueellenfrancisco' => 'Sue Ellen Francisco',
			'sunshiney' => 'Sunshiney',
			'supermercadoone' => 'Supermercado One',
			'suwannaphum' => 'Suwannaphum',
			'swankyandmoomoo' => 'Swanky and Moo Moo',
			'syncopate' => 'Syncopate',
			'tangerine' => 'Tangerine',
			'taprom' => 'Taprom',
			'telex' => 'Telex',
			'tenorsans' => 'Tenor Sans',
			'thegirlnextdoor' => 'The Girl Next Door',
			'tienne' => 'Tienne',
			'tinos' => 'Tinos',
			'titanone' => 'Titan One',
			'titilliumweb' => 'Titillium Web',
			'tradewinds' => 'Trade Winds',
			'trocchi' => 'Trocchi',
			'trochut' => 'Trochut',
			'trykker' => 'Trykker',
			'tulpenone' => 'Tulpen One',
			'ubuntu' => 'Ubuntu',
			'ubuntucondensed' => 'Ubuntu Condensed',
			'ubuntumono' => 'Ubuntu Mono',
			'ultra' => 'Ultra',
			'uncialantiqua' => 'Uncial Antiqua',
			'underdog' => 'Underdog',
			'unicaone' => 'Unica One',
			'unifrakturcook' => 'UnifrakturCook',
			'unifrakturmaguntia' => 'UnifrakturMaguntia',
			'unkempt' => 'Unkempt',
			'unlock' => 'Unlock',
			'unna' => 'Unna',
			'vt323' => 'VT323',
			'varela' => 'Varela',
			'varelaround' => 'Varela Round',
			'vastshadow' => 'Vast Shadow',
			'vibur' => 'Vibur',
			'vidaloka' => 'Vidaloka',
			'viga' => 'Viga',
			'voces' => 'Voces',
			'volkhov' => 'Volkhov',
			'vollkorn' => 'Vollkorn',
			'voltaire' => 'Voltaire',
			'waitingforthesunrise' => 'Waiting for the Sunrise',
			'wallpoet' => 'Wallpoet',
			'walterturncoat' => 'Walter Turncoat',
			'warnes' => 'Warnes',
			'wellfleet' => 'Wellfleet',
			'wireone' => 'Wire One',
			'yanonekaffeesatz' => 'Yanone Kaffeesatz',
			'yellowtail' => 'Yellowtail',
			'yesevaone' => 'Yeseva One',
			'yesteryear' => 'Yesteryear',
			'zeyada' => 'Zeyada'
			);

		$mpt_bg_patterns = array(
			'none' => $themefolder . '/img/patterns/none.png',
			'pattern_1' => $themefolder . '/img/patterns/pat_01_preview.png',
			'pattern_2' => $themefolder . '/img/patterns/pat_02_preview.png',
			'pattern_3' => $themefolder . '/img/patterns/pat_03_preview.png',
			'pattern_4' => $themefolder . '/img/patterns/pat_04_preview.png',
			'pattern_5' => $themefolder . '/img/patterns/pat_05_preview.png',
			'pattern_6' => $themefolder . '/img/patterns/pat_06_preview.png',
			'pattern_7' => $themefolder . '/img/patterns/pat_07_preview.png',
			'pattern_8' => $themefolder . '/img/patterns/pat_08_preview.png',
			'pattern_9' => $themefolder . '/img/patterns/pat_09_preview.png',
			'pattern_10' => $themefolder . '/img/patterns/pat_10_preview.png'
			);

		$btncolor_options = array(
			'grey' => 'Grey',
			'blue' => 'Blue',
			'lightblue' => 'Light Blue',
			'green' => 'Green',
			'red' => 'Red',
			'yellow' => 'Yellow',
			'black' => 'Black',
		);

		$tagcolor_options = array(
			'white' => 'White',
			'blue' => 'Blue',
			'lightblue' => 'Light Blue',
			'green' => 'Green',
			'red' => 'Red',
			'yellow' => 'Yellow',
			'black' => 'Black',
		);

		$socialicon_options = array(
			'none' => 'None',
			'facebook' => 'Facebook',
			'dribbble' => 'Dribbble',
			'flickr' => 'Flickr',
			'foursquare' => 'FourSquare',
			'google-plus' => 'Google Plus',
			'instagram' => 'Instagram',
			'linkedin' => 'Linkedin',
			'pinterest' => 'Pinterest',
			'renren' => 'RenRen',
			'skype' => 'Skype',
			'tumblr' => 'Tumblr',
			'twitter' => 'Twitter',
			'vk' => 'VK',
			'weibo' => 'Weibo',
			'xing' => 'Xing',
			'youtube' => 'YouTube',
			'rss' => 'RSS'
		);

/*  THE OPTIONS PANEL CREATION STARTS HERE */

		$options = array(); // DO NOT REMOVE
		
	/**** General Settings **************************************************************************************************/

		$options[] = array( "name" => __('General Settings','flexmarket'),
					"type" => "heading");

		$options[] = array( "name" => __('Website Logo','flexmarket'),
					"desc" => __('Upload a custom logo for your Website. <em>Recommended width - 170px</em>','flexmarket'),
					"id" => $shortname."_sitelogo",
					"std" => "",
					"type" => "upload");

		$options[] = array( "name" => __('Favicon','flexmarket'),
					"desc" => __('Upload a 16px x 16px image that will represent your website\'s favicon.<br /><br /><em>To ensure cross-browser compatibility, we recommend converting the favicon into .ico format before uploading. (<a href="http://www.favicon.cc/">www.favicon.cc</a>)</em>','flexmarket'),
					"id" => $shortname."_favicon",
					"std" => "",
					"type" => "upload");			

		$options[] = array( "name" => __('Footer Text','flexmarket'),
					"desc" => __('Override the default footer links by entering your own footer text here.','flexmarket'),
					"id" => $shortname."_cus_footer",
					"std" => "",
					"type" => "textarea");

		$options = apply_filters( 'mpt_theme_options_after_general_settings' , $options , 'flexmarket' );
					
	/**** Styling Options **************************************************************************************************/

		$options[] = array( "name" => __('Styling Options','flexmarket'),
					"type" => "heading");
					
		$options[] = array( "name" => __('Header Font','flexmarket'),
					"desc" => __('Select the font you want to use for header text','flexmarket'),
					"id" => $shortname."_theme_header_font",
					"std" => "arvo",
					"type" => "select",
					"options" => $mpt_google_web_fonts);	

		$options[] = array( "name" => __('Body Font','flexmarket'),
					"desc" => __('Select the font you want to use for body text','flexmarket'),
					"id" => $shortname."_theme_body_font",
					"std" => "ptsans",
					"type" => "select",
					"options" => $mpt_google_web_fonts);	

		$options[] = array( "name" => __('Use Custom Google Web Font','flexmarket'),
					"desc" => __('By default, this option is unchecked. If you want to use your own google web font then simply check this option.','flexmarket'),
					"id" => $shortname."_theme_custom_web_font",
					"std" => "false",
					"type" => "checkbox");

		$options[] = array( "name" => __('Custom Google Web Font For Header Text','flexmarket'),
					"desc" => __('Enter your custom google web font here.','flexmarket'),
					"id" => $shortname."_theme_custom_web_font_header",
					"std" => "Arvo:400,700",
					"type" => "text");	

		$options[] = array( "name" => __('Custom Google Web Font For Body Text','flexmarket'),
					"desc" => __('Enter your custom google web font here.','flexmarket'),
					"id" => $shortname."_theme_custom_web_font_body",
					"std" => "PT+Sans:400,700",
					"type" => "text");	

		$options[] = array( "name" => __('link Color','flexmarket'),
					"desc" => __('Pick a custom color for links.','flexmarket'),
					"id" => $shortname."_link_font_color",
					"std" => "",
					"type" => "color");
					
		$options[] = array( "name" => __('link hover Color','flexmarket'),
					"desc" => __('Pick a custom color for links hover.','flexmarket'),
					"id" => $shortname."_link_hover_font_color",
					"std" => "",
					"type" => "color");

		$options = apply_filters( 'mpt_theme_options_after_styling_options' , $options , 'flexmarket' );

	/**** Header Section **************************************************************************************************/

		$options[] = array( "name" => __('Header Section','flexmarket'),
					"type" => "heading");	

		$options[] = array( "name" => __('Background Color','flexmarket'),
					"desc" => __('Pick a custom background color for header section.','flexmarket'),
					"id" => $shortname."_header_section_bg_color",
					"std" => "",
					"type" => "color");	

		$options[] = array( "name" => __('Background Pattern','flexmarket'),
					"desc" => __('Select what type of background pattern you want to display.','flexmarket'),
					"id" => $shortname."_header_section_bg_pattern",
					"std" => "none",
					"type" => "images",
					"options" => $mpt_bg_patterns);	

		$options[] = array( "name" => __('Enable Sticky Header','flexmarket'),
					"desc" => __('if you want to make the header section sticky then simply enable this option.','flexmarket'),
					"id" => $shortname."_enable_sticky_header",
					"std" => "false",
					"type" => "checkbox");

		$options[] = array( "name" => __('Nav Menu: Text Color','flexmarket'),
					"desc" => __('Pick a custom text color for Nav Menu.','flexmarket'),
					"id" => $shortname."_header_section_text_color",
					"std" => "",
					"type" => "color");

		$options[] = array( "name" => __('Nav Menu: Text Color (hover)','flexmarket'),
					"desc" => __('Pick a custom text hover color for Nav Menu.','flexmarket'),
					"id" => $shortname."_header_section_text_color_hover",
					"std" => "",
					"type" => "color");

		$options[] = array( "name" => __('Nav Menu: Background Color (hover)','flexmarket'),
					"desc" => __('Pick a custom background color for nav menu.','flexmarket'),
					"id" => $shortname."_header_section_nav_bgcolor_hover",
					"std" => "",
					"type" => "color");	

		$options[] = array( "name" => __('Dropdown Menu: Background Color','flexmarket'),
					"desc" => __('Pick a custom background color for dropdown menu.','flexmarket'),
					"id" => $shortname."_header_section_dropdown_bgcolor",
					"std" => "",
					"type" => "color");

		$options[] = array( "name" => __('Dropdown Menu: Text Color','flexmarket'),
					"desc" => __('Pick a custom text color for dropdown menu.','flexmarket'),
					"id" => $shortname."_header_section_dropdown_textcolor",
					"std" => "",
					"type" => "color");

		$options[] = array( "name" => __('Dropdown Menu: Background Color (Hover)','flexmarket'),
					"desc" => __('Pick a custom background (hover) color for dropdown menu.','flexmarket'),
					"id" => $shortname."_header_section_dropdown_bgcolor_hover",
					"std" => "",
					"type" => "color");

		$options[] = array( "name" => __('Dropdown Menu: Text Color (Hover)','flexmarket'),
					"desc" => __('Pick a custom text (hover) color for dropdown menu.','flexmarket'),
					"id" => $shortname."_header_section_dropdown_textcolor_hover",
					"std" => "",
					"type" => "color");

		$options = apply_filters( 'mpt_theme_options_after_header_section' , $options , 'flexmarket' );


	/**** Homepage Layout **************************************************************************************************/						
		
		$options[] = array( "name" => __('Homepage Layout','flexmarket'),
					"type" => "heading");

		$options[] = array( "name" => __('Homepage Template ID','flexmarket'),
					"desc" => __('Insert the template id of your homepage here. If your template shortcode is [template id="22"], then you should enter only 22 here.','flexmarket'),
					"id" => $shortname."_homepage_layout_code",
					"std" => "",
					"type" => "text");

		$options[] = array( "name" => __('Show Footer Widget In Homepage','flexmarket'),
					"desc" => __('By default, this option is enabled. If you want to disable footer widget in homepage then simply uncheck this option.','flexmarket'),
					"id" => $shortname."_enable_homepage_footer_widget",
					"std" => "true",
					"type" => "checkbox");

		$options[] = array( "name" => __('Text Color','flexmarket'),
					"desc" => __('Pick a custom text color for this section.','flexmarket'),
					"id" => $shortname."_homepage_text_color",
					"std" => "",
					"type" => "color");

		$options[] = array( "name" => __('Background Color','flexmarket'),
					"desc" => __('Pick a custom background color for this section.','flexmarket'),
					"id" => $shortname."_homepage_bg_color",
					"std" => "",
					"type" => "color");

		$options[] = array( "name" => __('Background Pattern','flexmarket'),
					"desc" => __('Select what type of background pattern you want to display.','flexmarket'),
					"id" => $shortname."_homepage_bg_pattern",
					"std" => "none",
					"type" => "images",
					"options" => $mpt_bg_patterns);	

		$options = apply_filters( 'mpt_theme_options_after_homepage_layout' , $options , 'flexmarket' );

	/**** MarketPress **************************************************************************************************/

	if ( class_exists( 'MarketPress' ) ) {

		$options[] = array( "name" => __('MarketPress Settings','flexmarket'),
					"type" => "heading");	

		$options[] = array( "name" => __('Store Page Template ID','flexmarket'),
					"desc" => __('Insert the template id for the store page here. If your template shortcode is [template id="22"], then you should enter only 22 here.','flexmarket'),
					"id" => $shortname."_storepage_layout_code",
					"std" => "",
					"type" => "text");

		$options[] = array( "name" => __('Product Listing Layout','flexmarket'),
					"desc" => __('Select the layout you want to display in the product listing page','flexmarket'),
					"id" => $shortname."_mp_listing_layout",
					"std" => "3 Columns",
					"type" => "select",
					"options" => array(
						'2col' => '2 Columns',
						'3col' => '3 Columns',
						'4col' => '4 Columns'
						));

		$options[] = array( "name" => __('Product Listing Entries (Per Page)','flexmarket'),
					"desc" => __('Select the number of entries you want to display in each product listing page','flexmarket'),
					"id" => $shortname."_mp_listing_entries",
					"std" => "9",
					"type" => "select",
					"options" => array(
						'2' => '2',
						'3' => '3',
						'4' => '4',
						'5' => '5',
						'6' => '6',
						'7' => '7',
						'8' => '8',
						'9' => '9',
						'10' => '10',
						'11' => '11',
						'12' => '12',
						'13' => '13',
						'14' => '14',
						'15' => '15',
						'16' => '16',
						'17' => '17',
						'18' => '18',
						'19' => '19',
						'20' => '20'
						));		

		$options[] = array( "name" => __('Button Color','flexmarket'),
					"desc" => __('Select the color you want to use for all the buttons in MarketPress pages','flexmarket'),
					"id" => $shortname."_mp_main_btn_color",
					"std" => "Black",
					"type" => "select",
					"options" => $btncolor_options);	

		$options[] = array( "name" => __('Icon Tag Color','flexmarket'),
					"desc" => __('Select the color you want to use for all the Icon Tag in MarketPress pages','flexmarket'),
					"id" => $shortname."_mp_main_icon_tag_color",
					"std" => "Black",
					"type" => "select",
					"options" => $tagcolor_options);	

		$options[] = array( "name" => __('Enable Advanced Sort','flexmarket'),
					"desc" => __('if you want to enable the advanced soft feature in the product listing page then simply enable this option.','flexmarket'),
					"id" => $shortname."_enable_advanced_sort",
					"std" => "false",
					"type" => "checkbox");

		$options[] = array( "name" => __('Advanced Soft: Button Position','flexmarket'),
					"desc" => __('Select the position of advanced soft button.','flexmarket'),
					"id" => $shortname."_advanced_soft_btn_position",
					"std" => "Right",
					"type" => "select",
					"options" => array(
						'left' => 'Left',
						'center' => 'Center',
						'right' => 'Right',
						));

		$options = apply_filters( 'mpt_theme_options_after_marketpress_settings' , $options , 'flexmarket' );

	}

	/**** MP Dynamic Gird **************************************************************************************************/

	if ( class_exists( 'MPDG' ) ) {

		$options[] = array( "name" => __('MPDG Settings','flexmarket'),
					"type" => "heading");	

		$options[] = array( "name" => __('Enable MP Dynamic Grid In All Product Listing Pages','flexmarket'),
					"desc" => __('if you want to enable the MP dynamic gird in all product listing pages then simply enable this option.','flexmarket'),
					"id" => $shortname."_mpdg_enable_dg",
					"std" => "false",
					"type" => "checkbox");

		$options[] = array( "name" => __('Product Listing Layout','flexmarket'),
					"desc" => __('Select the layout you want to display in the product listing page','flexmarket'),
					"id" => $shortname."_mpdg_listing_layout",
					"std" => "3 Columns",
					"type" => "select",
					"options" => array(
						'2col' => '2 Columns',
						'3col' => '3 Columns',
						'4col' => '4 Columns',
						'5col' => '5 Columns'
						));

		$options[] = array( "name" => __('Product Listing Entries (Per Page)','flexmarket'),
					"desc" => __('Select the number of entries you want to display in each product listing page','flexmarket'),
					"id" => $shortname."_mpdg_listing_entries",
					"std" => "9",
					"type" => "select",
					"options" => array(
						'2' => '2',
						'3' => '3',
						'4' => '4',
						'5' => '5',
						'6' => '6',
						'7' => '7',
						'8' => '8',
						'9' => '9',
						'10' => '10',
						'11' => '11',
						'12' => '12',
						'13' => '13',
						'14' => '14',
						'15' => '15',
						'16' => '16',
						'17' => '17',
						'18' => '18',
						'19' => '19',
						'20' => '20',
						'21' => '21',
						'22' => '22',
						'23' => '23',
						'24' => '24',
						'25' => '25',
						'26' => '26',
						'27' => '27',
						'28' => '28',
						'29' => '29',
						'30' => '30',
						'31' => '31',
						'32' => '32',
						'33' => '33',
						'34' => '34',
						'35' => '35',
						'36' => '36',
						'37' => '37',
						'38' => '38',
						'39' => '39',
						'40' => '40'
						));		

		$options[] = array( "name" => __('Button Color','flexmarket'),
					"desc" => __('Select the color you want to use for the button','flexmarket'),
					"id" => $shortname."_mpdg_btn_color",
					"std" => "Black",
					"type" => "select",
					"options" => $btncolor_options);	

		$options[] = array( "name" => __('Icon Tag Color','flexmarket'),
					"desc" => __('Select the color you want to use for all the icon tag','flexmarket'),
					"id" => $shortname."_mpdg_icon_tag_color",
					"std" => "Black",
					"type" => "select",
					"options" => $tagcolor_options);	

		$options[] = array( "name" => __('Price Tag Color','flexmarket'),
					"desc" => __('Select the color you want to use for the price tag','flexmarket'),
					"id" => $shortname."_mpdg_price_tag_color",
					"std" => "Black",
					"type" => "select",
					"options" => array(
						'grey' => 'Grey',
						'lightblue' => 'Light Blue',
						'green' => 'Green',
						'red' => 'Red',
						'yellow' => 'Yellow',
						'black' => 'Black',
					));	

		$options = apply_filters( 'mpt_theme_options_after_mpdg_settings' , $options , 'flexmarket' );
	}

	/**** Page Settings **************************************************************************************************/

		$options[] = array( "name" => __('Page Settings','flexmarket'),
					"type" => "heading");	

		$options[] = array( "name" => __('Header Section: Background Color','flexmarket'),
					"desc" => __('Pick a custom background color for header section.','flexmarket'),
					"id" => $shortname."_page_header_section_bg_color",
					"std" => "",
					"type" => "color");	

		$options[] = array( "name" => __('Header Section: Text Color','flexmarket'),
					"desc" => __('Pick a custom text color for header section.','flexmarket'),
					"id" => $shortname."_page_header_section_text_color",
					"std" => "",
					"type" => "color");

		$options[] = array( "name" => __('Header Section: Background Pattern','flexmarket'),
					"desc" => __('Select what type of background pattern you want to display.','flexmarket'),
					"id" => $shortname."_page_header_section_bg_pattern",
					"std" => "none",
					"type" => "images",
					"options" => $mpt_bg_patterns);	

		$options[] = array( "name" => __('Content Section: Background Color','flexmarket'),
					"desc" => __('Pick a custom background color for content section.','flexmarket'),
					"id" => $shortname."_page_content_section_bg_color",
					"std" => "",
					"type" => "color");

		$options[] = array( "name" => __('Content Section: Text Color','flexmarket'),
					"desc" => __('Pick a custom text color for content section.','flexmarket'),
					"id" => $shortname."_page_content_section_text_color",
					"std" => "",
					"type" => "color");

		$options[] = array( "name" => __('Content Section: Background Pattern','flexmarket'),
					"desc" => __('Select what type of background pattern you want to display.','flexmarket'),
					"id" => $shortname."_page_content_section_bg_pattern",
					"std" => "none",
					"type" => "images",
					"options" => $mpt_bg_patterns);	

		$options = apply_filters( 'mpt_theme_options_after_page_settings' , $options , 'flexmarket' );

	/**** Post Settings **************************************************************************************************/

		$options[] = array( "name" => __('Post Settings','flexmarket'),
					"type" => "heading");	

		$options[] = array( "name" => __('Header Section: Background Color','flexmarket'),
					"desc" => __('Pick a custom background color for header section.','flexmarket'),
					"id" => $shortname."_post_header_section_bg_color",
					"std" => "",
					"type" => "color");	

		$options[] = array( "name" => __('Header Section: Text Color','flexmarket'),
					"desc" => __('Pick a custom text color for header section.','flexmarket'),
					"id" => $shortname."_post_header_section_text_color",
					"std" => "",
					"type" => "color");

		$options[] = array( "name" => __('Header Section: Background Pattern','flexmarket'),
					"desc" => __('Select what type of background pattern you want to display.','flexmarket'),
					"id" => $shortname."_post_header_section_bg_pattern",
					"std" => "none",
					"type" => "images",
					"options" => $mpt_bg_patterns);	

		$options[] = array( "name" => __('Content Section: Background Color','flexmarket'),
					"desc" => __('Pick a custom background color for content section.','flexmarket'),
					"id" => $shortname."_post_content_section_bg_color",
					"std" => "",
					"type" => "color");

		$options[] = array( "name" => __('Content Section: Text Color','flexmarket'),
					"desc" => __('Pick a custom text color for content section.','flexmarket'),
					"id" => $shortname."_post_content_section_text_color",
					"std" => "",
					"type" => "color");

		$options[] = array( "name" => __('Content Section: Background Pattern','flexmarket'),
					"desc" => __('Select what type of background pattern you want to display.','flexmarket'),
					"id" => $shortname."_post_content_section_bg_pattern",
					"std" => "none",
					"type" => "images",
					"options" => $mpt_bg_patterns);	

		$options = apply_filters( 'mpt_theme_options_after_post_settings' , $options , 'flexmarket' );

	/**** Sidebar Widget **************************************************************************************************/

		$options[] = array( "name" => __('Sidebar Widget Settings','flexmarket'),
					"type" => "heading");	


		$options[] = array( "name" => __('Background Color','flexmarket'),
					"desc" => __('Pick a custom background color for sidebar widget.','flexmarket'),
					"id" => $shortname."_sidebar_widget_bg_color",
					"std" => "",
					"type" => "color");

		$options[] = array( "name" => __('Text Color','flexmarket'),
					"desc" => __('Pick a custom text color for sidebar widget.','flexmarket'),
					"id" => $shortname."_sidebar_widget_text_color",
					"std" => "",
					"type" => "color");

		$options[] = array( "name" => __('Link Color','flexmarket'),
					"desc" => __('Pick a custom link color for sidebar widget.','flexmarket'),
					"id" => $shortname."_sidebar_widget_link_color",
					"std" => "",
					"type" => "color");

		$options[] = array( "name" => __('Icon Color','flexmarket'),
					"desc" => __('Select the color of arrow icon in the sidebar widget .','flexmarket'),
					"id" => $shortname."_sidebar_widget_icon_color",
					"std" => "",
					"type" => "color");

		$options[] = array( "name" => __('Background Color (hover)','flexmarket'),
					"desc" => __('Pick a custom background color for sidebar widget (on hover).','flexmarket'),
					"id" => $shortname."_sidebar_widget_bg_color_hover",
					"std" => "",
					"type" => "color");

		$options[] = array( "name" => __('Text Color (hover)','flexmarket'),
					"desc" => __('Pick a custom text color for sidebar widget (on hover).','flexmarket'),
					"id" => $shortname."_sidebar_widget_text_color_hover",
					"std" => "",
					"type" => "color");

		$options[] = array( "name" => __('Link Color (Hover)','flexmarket'),
					"desc" => __('Pick a custom link color for sidebar widget (on hover).','flexmarket'),
					"id" => $shortname."_sidebar_widget_link_color_hover",
					"std" => "",
					"type" => "color");

		$options[] = array( "name" => __('Icon Color (hover)','flexmarket'),
					"desc" => __('Select the color of arrow icon in the sidebar widget (on hover).','flexmarket'),
					"id" => $shortname."_sidebar_widget_icon_color_hover",
					"std" => "",
					"type" => "color");

		$options = apply_filters( 'mpt_theme_options_after_sidebar_widget_settings' , $options , 'flexmarket' );


	/**** Footer Widget **************************************************************************************************/

		$options[] = array( "name" => __('Footer Widget Settings','flexmarket'),
					"type" => "heading");	

		$options[] = array( "name" => __('Show Footer Widget','flexmarket'),
					"desc" => __('By default, this option is enabled. If you want to disable the footer widget then simply uncheck this option.','flexmarket'),
					"id" => $shortname."_enable_footer_widget",
					"std" => "true",
					"type" => "checkbox");

		$options[] = array( "name" => __('Footer Widget Layout','flexmarket'),
					"desc" => __('Select the layout you want to display in footer widget.','flexmarket'),
					"id" => $shortname."_footer_widget_setting",
					"std" => "widget444",
					"type" => "images",
					"options" => array(
						'widget444' => $sampleurl . 'sample-layouts/footer-widget-layout-444.png',
						'widget633' => $sampleurl . 'sample-layouts/footer-widget-layout-633.png',
						'widget336' => $sampleurl . 'sample-layouts/footer-widget-layout-336.png'
						));	

		$options[] = array( "name" => __('Background Color','flexmarket'),
					"desc" => __('Pick a custom background color for footer widget.','flexmarket'),
					"id" => $shortname."_footer_widget_bg_color",
					"std" => "",
					"type" => "color");	

		$options[] = array( "name" => __('Text Color','flexmarket'),
					"desc" => __('Pick a custom text color for footer widget.','flexmarket'),
					"id" => $shortname."_footer_widget_text_color",
					"std" => "",
					"type" => "color");

		$options[] = array( "name" => __('Background Pattern','flexmarket'),
					"desc" => __('Select what type of background pattern you want to display.','flexmarket'),
					"id" => $shortname."_footer_widget_bg_pattern",
					"std" => "none",
					"type" => "images",
					"options" => $mpt_bg_patterns);	

		$options[] = array( "name" => __('Link Color','flexmarket'),
					"desc" => __('Pick a custom link color for footer widget.','flexmarket'),
					"id" => $shortname."_footer_widget_link_color",
					"std" => "",
					"type" => "color");

		$options[] = array( "name" => __('Link Color (hover)','flexmarket'),
					"desc" => __('Pick a custom link hover color for footer widget.','flexmarket'),
					"id" => $shortname."_footer_widget_link_color_hover",
					"std" => "",
					"type" => "color");

		$options[] = array( "name" => __('Icon Color','flexmarket'),
					"desc" => __('Select the color of arrow icon in the footer widget .','flexmarket'),
					"id" => $shortname."_footer_widget_icon_color",
					"std" => "",
					"type" => "color");

		$options = apply_filters( 'mpt_theme_options_after_footer_widget_settings' , $options , 'flexmarket' );

	/**** Footer Section **************************************************************************************************/

		$options[] = array( "name" => __('Footer Section','flexmarket'),
					"type" => "heading");	


		$options[] = array( "name" => __('Background Color','flexmarket'),
					"desc" => __('Pick a custom background color for footer section.','flexmarket'),
					"id" => $shortname."_footer_section_bg_color",
					"std" => "",
					"type" => "color");	

		$options[] = array( "name" => __('Text Color','flexmarket'),
					"desc" => __('Pick a custom text color for footer section.','flexmarket'),
					"id" => $shortname."_footer_section_text_color",
					"std" => "",
					"type" => "color");

		$options[] = array( "name" => __('Background Pattern','flexmarket'),
					"desc" => __('Select what type of background pattern you want to display.','flexmarket'),
					"id" => $shortname."_footer_section_bg_pattern",
					"std" => "none",
					"type" => "images",
					"options" => $mpt_bg_patterns);	

		$options[] = array( "name" => __('Link Color','flexmarket'),
					"desc" => __('Pick a custom link color for footer section.','flexmarket'),
					"id" => $shortname."_footer_section_link_color",
					"std" => "",
					"type" => "color");

		$options[] = array( "name" => __('Link Color (hover)','flexmarket'),
					"desc" => __('Pick a custom link hover color for footer section.','flexmarket'),
					"id" => $shortname."_footer_section_link_color_hover",
					"std" => "",
					"type" => "color");

		$options = apply_filters( 'mpt_theme_options_after_footer_section' , $options , 'flexmarket' );

	/**** Social Icon **************************************************************************************************/

		$options[] = array( "name" => __('Social Icon','flexmarket'),
					"type" => "heading");	

		$options[] = array( "name" => __('Social Icon 1: Icon','flexmarket'),
					"desc" => __('Select what type of icon you want to use for social icon 1.','flexmarket'),
					"id" => $shortname."_social_icon_1_icon",
					"std" => "Facebook",
					"type" => "select",
					"options" => $socialicon_options);							

		$options[] = array( "name" => __('Social Icon 1: Profile Url','flexmarket'),
					"desc" => __('Enter your profile / website url here for social icon 1.','flexmarket'),
					"id" => $shortname."_social_icon_1_url",
					"std" => "",
					"type" => "text");

		$options[] = array( "name" => __('Social Icon 2: Icon','flexmarket'),
					"desc" => __('Select what type of icon you want to use for social icon 2.','flexmarket'),
					"id" => $shortname."_social_icon_2_icon",
					"std" => "Twitter",
					"type" => "select",
					"options" => $socialicon_options);							

		$options[] = array( "name" => __('Social Icon 2: Profile Url','flexmarket'),
					"desc" => __('Enter your profile / website url here for social icon 2.','flexmarket'),
					"id" => $shortname."_social_icon_2_url",
					"std" => "",
					"type" => "text");

		$options[] = array( "name" => __('Social Icon 3: Icon','flexmarket'),
					"desc" => __('Select what type of icon you want to use for social icon 3.','flexmarket'),
					"id" => $shortname."_social_icon_3_icon",
					"std" => "Google Plus",
					"type" => "select",
					"options" => $socialicon_options);							

		$options[] = array( "name" => __('Social Icon 3: Profile Url','flexmarket'),
					"desc" => __('Enter your profile / website url here for social icon 3.','flexmarket'),
					"id" => $shortname."_social_icon_3_url",
					"std" => "",
					"type" => "text");

		$options[] = array( "name" => __('Social Icon 4: Icon','flexmarket'),
					"desc" => __('Select what type of icon you want to use for social icon 4.','flexmarket'),
					"id" => $shortname."_social_icon_4_icon",
					"std" => "Dribbble",
					"type" => "select",
					"options" => $socialicon_options);							

		$options[] = array( "name" => __('Social Icon 4: Profile Url','flexmarket'),
					"desc" => __('Enter your profile / website url here for social icon 4.','flexmarket'),
					"id" => $shortname."_social_icon_4_url",
					"std" => "",
					"type" => "text");

		$options[] = array( "name" => __('Social Icon 5: Icon','flexmarket'),
					"desc" => __('Select what type of icon you want to use for social icon 5.','flexmarket'),
					"id" => $shortname."_social_icon_5_icon",
					"std" => "YouTube",
					"type" => "select",
					"options" => $socialicon_options);							

		$options[] = array( "name" => __('Social Icon 5: Profile Url','flexmarket'),
					"desc" => __('Enter your profile / website url here for social icon 5.','flexmarket'),
					"id" => $shortname."_social_icon_5_url",
					"std" => "",
					"type" => "text");


		$options[] = array( "name" => __('Social Icon 6: Icon','flexmarket'),
					"desc" => __('Select what type of icon you want to use for social icon 6.','flexmarket'),
					"id" => $shortname."_social_icon_6_icon",
					"std" => "RSS",
					"type" => "select",
					"options" => $socialicon_options);							

		$options[] = array( "name" => __('Social Icon 6: Profile Url','flexmarket'),
					"desc" => __('Enter your profile / website url here for social icon 6.','flexmarket'),
					"id" => $shortname."_social_icon_6_url",
					"std" => "",
					"type" => "text");

		$options[] = array( "name" => __('Social Icon 7: Icon','flexmarket'),
					"desc" => __('Select what type of icon you want to use for social icon 7.','flexmarket'),
					"id" => $shortname."_social_icon_7_icon",
					"std" => "None",
					"type" => "select",
					"options" => $socialicon_options);							

		$options[] = array( "name" => __('Social Icon 7: Profile Url','flexmarket'),
					"desc" => __('Enter your profile / website url here for social icon 7.','flexmarket'),
					"id" => $shortname."_social_icon_7_url",
					"std" => "",
					"type" => "text");

		$options[] = array( "name" => __('Social Icon 8: Icon','flexmarket'),
					"desc" => __('Select what type of icon you want to use for social icon 8.','flexmarket'),
					"id" => $shortname."_social_icon_8_icon",
					"std" => "None",
					"type" => "select",
					"options" => $socialicon_options);							

		$options[] = array( "name" => __('Social Icon 8: Profile Url','flexmarket'),
					"desc" => __('Enter your profile / website url here for social icon 8.','flexmarket'),
					"id" => $shortname."_social_icon_8_url",
					"std" => "",
					"type" => "text");

		$options = apply_filters( 'mpt_theme_options_after_social_icons' , $options , 'flexmarket' );

					
	/**** SEO Settings **************************************************************************************************/

		$options[] = array( "name" => __('SEO Settings','flexmarket'),
					"type" => "heading");
		
		$options[] = array( "name" => __('Enable Custom Title','flexmarket'),
					"desc" => __('if you want to create a custom title then simply enable this option and fill in the custom title field below.','flexmarket'),
					"id" => $shortname."_enable_custom_title",
					"std" => "false",
					"type" => "checkbox");
					
		$options[] = array( "name" => __('Enable Meta Description','flexmarket'),
					"desc" => __('If you would like to use a different description then enable this option and fill in the custom description field below.','flexmarket'),
					"id" => $shortname."_enable_meta_desc",
					"std" => "false",
					"type" => "checkbox");
					
		$options[] = array( "name" => __('Enable Meta Keywords','flexmarket'),
					"desc" => __('If you want to add meta keywords to your header then enable this option and fill in the custom keywords field below.','flexmarket'),
					"id" => $shortname."_enable_meta_keywords",
					"std" => "false",
					"type" => "checkbox");
					
		$options[] = array( "type" => "divider");
					
		$options[] = array( "name" => __('Custom Title (If enable)','flexmarket'),
					"desc" => __('If you have enabled custom titles you can add your custom title here.','flexmarket'),
					"id" => $shortname."_cus_title",
					"std" => "",
					"type" => "text");
					
		$options[] = array( "name" => __('Meta Description (If enable)','flexmarket'),
					"desc" => __('If you have enabled meta descriptions you can add your custom description here.','flexmarket'),
					"id" => $shortname."_cus_meta_desc",
					"std" => "",
					"type" => "textarea");					

		$options[] = array( "name" => __('Meta Keywords (If enable)','flexmarket'),
					"desc" => __('If you have enabled meta keywords you can add your custom keywords here. Keywords should be separated by comas. For example: keyword1,keyword2,keyword3','flexmarket'),
					"id" => $shortname."_cus_meta_keywords",
					"std" => "",
					"type" => "text");			

		$options = apply_filters( 'mpt_theme_options_after_seo_settings' , $options , 'flexmarket' );		

	/**** Code Integration **************************************************************************************************/

		$options[] = array( "name" => __('Code Integration','flexmarket'),
					"type" => "heading");
					
		$options[] = array( "name" => __('Enable Header Code','flexmarket'),
					"desc" => __('Uncheck this option will disable the header code below from your site.','flexmarket'),
					"id" => $shortname."_enable_header_code",
					"std" => "false",
					"type" => "checkbox");

		$options[] = array( "name" => __('Enable Body Code','flexmarket'),
					"desc" => __('Uncheck this option will disable the body code below from your site.','flexmarket'),
					"id" => $shortname."_enable_body_code",
					"std" => "false",
					"type" => "checkbox");
					
		$options[] = array( "name" => __('Enable Top Code (Single Post)','flexmarket'),
					"desc" => __('Uncheck this option will disable the top code (single post) below from your site.','flexmarket'),
					"id" => $shortname."_enable_top_code",
					"std" => "false",
					"type" => "checkbox");
					
		$options[] = array( "name" => __('Enable Bottom Code (Single Post)','flexmarket'),
					"desc" => __('Uncheck this option will disable the bottom code (single post) below from your site.','flexmarket'),
					"id" => $shortname."_enable_bottom_code",
					"std" => "false",
					"type" => "checkbox");
					
		$options[] = array( "name" => __('Header Code','flexmarket'),
					"desc" => __('Add code to the &lt;head&gt; section of your website. If you want to add javascript or css to all pages, you can place the code here.','flexmarket'),
					"id" => $shortname."_header_code",
					"std" => "",
					"type" => "textarea");

		$options[] = array( "name" => __('Body Code','flexmarket'),
					"desc" => __('Add code to the &lt;body&gt; section of your website. If you want to add tracking code to your website (such as Google Analytics), you can place the code here.','flexmarket'),
					"id" => $shortname."_body_code",
					"std" => "",
					"type" => "textarea");
					
		$options[] = array( "name" => __('Top Code (single post)','flexmarket'),
					"desc" => __('Add code to the top section of your posts. If you want to add social bookmarking links to the top of your posts, you can place the code here.','flexmarket'),
					"id" => $shortname."_top_code",
					"std" => "",
					"type" => "textarea");
					
		$options[] = array( "name" => __('Bottom Code (single post)','flexmarket'),
					"desc" => __('Add code to the bottom section of your posts. If you want to add social bookmarking links to the bottom of your posts (before the comments), you can place the code here.','flexmarket'),
					"id" => $shortname."_bottom_code",
					"std" => "",
					"type" => "textarea");
					
		$options = apply_filters( 'mpt_theme_options_after_code_integration' , $options , 'flexmarket' );

		update_option('m413_template',$options);
		update_option('m413_themename',$themename);
		update_option('m413_shortname',$shortname);

	}
}