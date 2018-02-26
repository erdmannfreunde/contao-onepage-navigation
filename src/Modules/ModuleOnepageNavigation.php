<?php 

/**
 * @package     Onepage Navigation
 * @author      Sascha Brandhoff (https://github.com/Sascha-Brandhoff/onepage-navigation)
 * @author      Basti Buck (http://www.bastibuck.de)
 * @license     LGPLv3
 * @copyright   Erdmann & Freunde (https://erdmann-freunde.de)
 */


namespace EuF\OnepageNavigation\Modules;

use Patchwork\Utf8;

class ModuleOnepageNavigation extends \Module
{
    /**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_onepage_navigation';
    
    /**
     * Display a wildcard in the back end
     *
     * @return string
     */
	public function generate()
	{
        if (TL_MODE == 'BE')
		{
			/** @var BackendTemplate|object $objTemplate */
			$objTemplate = new \BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### ' . Utf8::strtoupper($GLOBALS['TL_LANG']['FMD']['onepage_navigation'][0]). ' ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
		}		
		
		return parent::generate();
	}

    /**
	 * Generate the module
	 */
	protected function compile()
	{
        // initialize empty array
		$arrNavigation = array();
		
		// get current page id
		$intPageID = $GLOBALS['objPage']->id;

		// override page ID if a rootPage is defined
		if($this->defineRoot) {
			$intPageID = $this->rootPage;
			$rootPageId = \PageModel::findById($this->rootPage);
			$rootPageAlias = $rootPageId->getFrontendUrl('');
		}
		
		// get articles by page id
		$objArticle = \ArticleModel::findByPid($intPageID, array('order' => 'sorting'));
		
		// put articles into array if they should be displayed as navigation items
		while($objArticle->next())
		{
			if($objArticle->addNavigation && $objArticle->published)
			{
				if($objArticle->navigation_title)
				{
					$objArticle->title = $objArticle->navigation_title;
				}

				// get jumpTo target and add to article so it can be rendered in template
				$cssID = \StringUtil::deserialize($objArticle->cssID);

				if (empty($cssID[0]))
				{
					if($objArticle->navigation_jumpTo) {						
						$cssID = array($objArticle->navigation_jumpTo, $cssID[1]);
					}
					else {
						$cssID = array('article-'.$objArticle->id, $cssID[1]);
					}
				}
				$cssID[1] .= ' onepage_article'; 
				$objArticle->cssID = serialize($cssID);
				$objArticle->articleID = $cssID[0];
				$objArticle->onepage_jump = $rootPageAlias.'#'.$cssID[0];

				$arrNavigation[] = (object) $objArticle->row();
			}
		}

		if($arrNavigation) {
			// add first and last class to items
			$arrNavigation[0]->css = 'first';
			$arrNavigation[count($arrNavigation) - 1]->css = 'last';
	
			// send to template
			$this->Template->hasItems = true;
			$this->Template->navigation = $arrNavigation;
		}

	}
}
