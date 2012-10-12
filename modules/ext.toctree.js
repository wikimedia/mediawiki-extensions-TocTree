/*
 * JavaScript functions for the TocTree extension 
 * to display the toc structure
 *
 * @package MediaWiki
 * @subpackage Extensions
 * @author Roland Unger
 * @copyright © 2007 Roland Unger
 * v1.0 of 2007/11/04
 * @licence GNU General Public Licence 2.0 or later
 */

/* Variables defined by php script and added to the header
 var tocTreeExpandMsg = "Expand";
 var tocTreeCollapseMsg = "Collapse";
 var tocTreeCollapsed = true;
 var tocTreeFloatedToc = true; */

function addEvent(obj, eventType, aFunction, isCapture) {
	if (obj.addEventListener) {  // W3C DOM
		obj.addEventListener(eventType, aFunction, isCapture);
		return true;
	}
	else if (obj.attachEvent) {  // Internet Explorer
		return obj.attachEvent("on" + eventType, aFunction);
	}
	else
		return false;
}

function expandNode(aLink, expandIt) {
	var ul = aLink.parentNode.parentNode.getElementsByTagName("ul");
	if (ul.length > 0) for (i = 0; i < ul.length; i++) {
		if (expandIt) ul[i].style.display = "block";
		else ul[i].style.display = "none";
	}
}

function processClickEvent(event) {
	var toggleLink = null;
	if (event.type == "click") {
		// Internet Explorer
		if (event.srcElement) toggleLink = event.srcElement;
		// W3C DOM
		if (event.currentTarget) toggleLink = event.currentTarget;

		if (toggleLink != null) {
			if (toggleLink.innerHTML == "+") {
				toggleLink.innerHTML = "–";
				toggleLink.title = tocTreeCollapseMsg;
				expandNode(toggleLink, true);
			}
			else {
				toggleLink.innerHTML = "+";
				toggleLink.title = tocTreeExpandMsg;
				expandNode(toggleLink, false);
			}
		}
	}
}

function setToggleNodes() {
	var toc, mainUl, mainList, subList, toggleLink, toggleSpan, mlClass;

	if (document.getElementById) {
		toc = document.getElementById("toc");
		if (toc != null) {
			if (tocTreeFloatedToc)
				toc.className = toc.className + " tocFloat";
			toc.cellSpacing = 0;
			mainUl = toc.getElementsByTagName("ul")[0];
			mainList = toc.getElementsByTagName("li");
			if (mainList.length > 0) for (i = 0; i < mainList.length; i++) {
				mlClass = mainList[i].className;
				if (mlClass.indexOf("toclevel-1") != -1) {
					mainList[i].style.position = "relative";
					subList = mainList[i].getElementsByTagName("ul");
					if (subList.length > 0) {
						if (mainUl != null) mainUl.className = "tocUl";

						toggleLink = document.createElement("span");
						toggleLink.className = "toggleSymbol";
						if (tocTreeCollapsed) {
							toggleLink.title = tocTreeExpandMsg;
							toggleLink.appendChild(document.createTextNode("+"));
						} else {
							toggleLink.title = tocTreeCollapseMsg;
							toggleLink.appendChild(document.createTextNode("–"));
						}
						addEvent(toggleLink, "click", processClickEvent, false);
						toggleSpan = document.createElement("span");
						toggleSpan.className = "toggleNode";
						toggleSpan.appendChild(document.createTextNode('['));
						toggleSpan.appendChild(toggleLink);
						toggleSpan.appendChild(document.createTextNode(']'));
						mainList[i].insertBefore(toggleSpan, mainList[i].firstChild);

						if (tocTreeCollapsed)
							for (j = 0; j < subList.length; j++) subList[j].style.display = "none";
					}
				}
			}
		}
	}
	return true;
}

addOnloadHook(setToggleNodes);
