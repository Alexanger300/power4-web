package main

import (
	"net/http"

	"github.com/pkg/browser"
)

func main() {
	http.Handle("/", http.FileServer(http.Dir("./")))
	go browser.OpenURL("http://localhost/ProjetHangMan/power4-web/templates/home_page/home_page.html") // ouvre le navigateur et le lien associé
	http.ListenAndServe(":8080", nil)
}
