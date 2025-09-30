package main

import (
	"fmt"
	"log"
	"net/http"
)

func main() {
	// Route pour servir les fichiers statiques dans welcome/
	http.Handle("/", http.FileServer(http.Dir("./welcome")))

	// Route qui lance l'action quand le bouton est cliqué
	http.HandleFunc("/run", func(w http.ResponseWriter, r *http.Request) {
		w.Header().Set("Content-Type", "text/plain")
		// Ici tu peux mettre n'importe quel programme Go
		result := "Action exécutée côté serveur !"
		fmt.Fprint(w, result)
	})

	port := ":8080"
	fmt.Printf("Serveur démarré sur http://localhost%s\n", port)
	log.Fatal(http.ListenAndServe(port, nil))
}
