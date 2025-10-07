package main

import (
	"fmt"
	"log"
	"net/http"
)

func main() {
	// Servir les dossiers statiques
	http.Handle("/power4/", http.StripPrefix("/power4/", http.FileServer(http.Dir("./power4"))))
	http.Handle("/home_page/", http.StripPrefix("/home_page/", http.FileServer(http.Dir("./home_page"))))
	http.Handle("/css/", http.StripPrefix("/css/", http.FileServer(http.Dir("./css"))))

	// Page d’accueil
	http.HandleFunc("/", func(w http.ResponseWriter, r *http.Request) {
		http.ServeFile(w, r, "./home_page/home_page.html")
	})

	port := ":8080"
	fmt.Printf("Serveur démarré sur http://localhost%s\n", port)
	log.Fatal(http.ListenAndServe(port, nil))
}
