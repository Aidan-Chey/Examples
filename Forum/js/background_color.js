function change_bg(bg3){
	switch(bg3.id){
		case "Dark":
			document.documentElement.style.background="hsl(0,0%,15%)";
			break;
		case "Green":
			document.documentElement.style.background="hsl(90,90%,20%)";
			break;
		case "Blue":
			document.documentElement.style.background="hsl(200,90%,25%)";
			break;
	}
}