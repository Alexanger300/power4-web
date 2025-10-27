package main

import (
	"log"
	"net/http"
)

func main() {
	// Initialisation du jeu

	// Servir les fichiers statiques
	http.Handle("/css/", http.StripPrefix("/css/", http.FileServer(http.Dir("./css"))))
	http.Handle("/power4/", http.StripPrefix("/power4/", http.FileServer(http.Dir("./power4"))))
	http.Handle("/home_page/", http.StripPrefix("/home_page/", http.FileServer(http.Dir("./home_page"))))
	http.Handle("/login/", http.StripPrefix("/login/", http.FileServer(http.Dir("./login"))))

	// Page d'accueil
	http.HandleFunc("/", func(w http.ResponseWriter, r *http.Request) {
		http.ServeFile(w, r, "./login/inscription.php")
	})

	port := ":8080"
	log.Printf("Serveur démarré sur http://localhost%s\n", port)
	log.Fatal(http.ListenAndServe(port, nil))
}
