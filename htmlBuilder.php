<?php



class Content
{
	private $addons;
	private $section;
	private $modal;
	private $csslinks;
	private $jsLinks;
	private $fonts;
	private $head;
	private $footer;
	private $content;
	private $aside;
	
	function __construct($meta, $fonts, $cssLinks, $jsLinks, $Title, $modal)
	{	
	 $this->modal = $modal;
	 $this->meta = $meta;
	 $this->fonts = $fonts;
	 $this->cssLinks = $cssLinks;
	 $this->jsLinks = $jsLinks;
	 
	 $this->head = "<head>\n".$meta.$fonts.$jsLinks.$cssLinks."\n<title>".$Title."</title>\n"."</head>";
	 $this->footer =" <footer>
						<p>mySite.pl © 2018</p>
					  </footer>";
	 
	}
	
	function setHeader($buttons)
	{
		$this->headr = 
	"<header>
	<img src='https://orig00.deviantart.net/a4be/f/2017/331/8/2/happy_tree_friends___flippy_by_princesshetalia-dbv3nzh.png' id = 'obrazek'  alt='Smiley face'>\n
	<h1>Forum</h1>\n
	<div id='righttopCorn'>\n
	<div class='toright'>\n"
	.$buttons.		  
	"\n</div>\n	
	<form action='profile.php' method= 'get'> <input name='lo' type='search' placeholder='Search'></form>\n
	</div>\n
	</header>\n";
			
	}
	
	function setContent($content)
	{
		$this->content =  "<section id ='main'>\n".$content."\n</section>\n";
		
	}
	 
	function setAside($numHref, $asideMenu)
	{
		$conteiner = "<aside>\n<nav>\n<ul>\n";
		for ($i = 0; $i < $numHref; $i++) 
		{ 
			$conteiner  .= "<li><a href='".$asideMenu["menuHref"][$i]."'>".$asideMenu["menuName"][$i]."</a></li>\n";  // .= to to samo co += z tym że działa na stringach :o
		}
		$conteiner  .= "</ul>\n</nav>\n</aside>\n";
		
		$this->aside = $conteiner;
	}
	
	
	public function Show()
    {
      echo "<!DOCTYPE html><html lang='pl'>".$this->head."\n<body>\n<div id = 'container'>".$this->headr.$this->aside.$this->content.$this->footer."\n</div>".$this->modal."\n</body>\n</html>";
       
    }
	
 
	 
	
}



?>