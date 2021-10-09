window.addEventListener("load", () => {
	const block = document.querySelector(".alert");

	setTimeout(() => {
        block.style.color = "white";

		block.style.opacity = "0";
		block.style.height = "0";
        block.style.border = "none";

        block.style.margin = "0";
        block.style.background = "none";
        
        block.style.padding = "0";
        // block.style.fontSize = "0";
        block.style.transform = "scale(0)";
		
	}, 5000);

	block.addEventListener("transitionend", () => {
		// block.style.display = "none"; //скрыть
		block.remove(); // удалить 
	});
});
