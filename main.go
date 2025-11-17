package main

import (
	"net/http"

	"github.com/pkg/browser"
)

func main() {
	http.Handle("/", http.FileServer(http.Dir("./")))
	go browser.OpenURL("http://localhost/ProjetHangMan/power4-web/home_page/home_page.html")                     // ouvre le navigateur
	go browser.OpenURL("http://localhost/phpmyadmin/index.php?route=/&route=%2F&db=site-web&table=utilisateurs") //ouvre la base de données phpmyadmin
	http.ListenAndServe(":8080", nil)
}
