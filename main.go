package main

import (
	"net/http"

	"github.com/pkg/browser"
)

func main() {
	http.Handle("/", http.FileServer(http.Dir("./")))
	go browser.OpenURL("http://localhost/power4-web-1/home_page/home_page.html") // ouvre le navigateur
	http.ListenAndServe(":8080", nil)
}
