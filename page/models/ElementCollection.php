<?php
require_once MODELROOT."Autoloader.php";
class ElementCollection
{
	private $elements = array();

	public function addElement($element)
	{
		$this->elements[] = $element;
	}

    public function showElements()
	{
		foreach ($this->elements as $element)
		{
			if ($element instanceof HtmlDoc)
			{
				$element->show();
			}
			elseif ($element instanceof IShowContent)
			{	
				$element->showContent();
			}  
		}	
	}
}