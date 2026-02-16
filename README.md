# Webeez Legacy - Local Development Environment

Αυτό το repository περιέχει το τοπικό περιβάλλον ανάπτυξης για το Legacy site του Webeez. Η υποδομή βασίζεται σε Docker (με Traefik Proxy), χρησιμοποιεί Gulp για το Frontend (SCSS/JS) και GitHub Actions για αυτόματο deployment στον Live Server.

---

## 1. Προαπαιτούμενα

Για να τρέξει το project τοπικά, χρειάζεστε εγκατεστημένα τα εξής:
- Docker & Docker Compose
- Git
(Δεν χρειάζεται να έχετε εγκατεστημένα PHP, Apache ή MySQL στον υπολογιστή σας. Όλα τρέχουν μέσα στα Docker Containers).

---

## 2. Πρώτη Εγκατάσταση (Getting Started)

Βήμα 1: Κατέβασμα του Κώδικα
git clone git@github.com:antoniszachos/webeez-legacy.git
cd webeez-legacy

Βήμα 2: Ρύθμιση των Hosts
Προσθέστε τις παρακάτω εγγραφές στο αρχείο hosts του υπολογιστή σας:
127.0.0.1   legacy.webeez.gr bs-legacy.webeez.gr

Βήμα 3: Τα "Κρυφά" Αρχεία
1. Δημιουργήστε ένα αρχείο .env στον κεντρικό φάκελο με τους κωδικούς της τοπικής βάσης.
2. Τοποθετήστε το αρχείο .sql (το dump της Live βάσης) στον κατάλληλο φάκελο.

Βήμα 4: Εκκίνηση!
docker compose up -d
Το site είναι πλέον διαθέσιμο στο: http://legacy.webeez.gr

---

## 3. Frontend Ανάπτυξη (Gulp & BrowserSync)

Εγκατάσταση Πακέτων (Μόνο την 1η φορά):
docker compose exec wordpress_legacy npm install

Εκκίνηση Development (Live Reload):
docker compose exec wordpress_legacy npx gulp
(Η Live προβολή γίνεται μέσω του: http://bs-legacy.webeez.gr)

Ετοιμασία για Live (Production Build):
ΠΡΙΝ κάνετε commit, τρέξτε το build για να δημιουργηθούν τα συμπιεσμένα αρχεία:
docker compose exec wordpress_legacy gulp build

---

## 4. Deployment (Ανέβασμα στο Live Site)

Το ανέβασμα του κώδικα στον Live Server γίνεται αυτόματα μέσω GitHub Actions με κάθε "git push" στο branch "main".

Τι ανεβαίνει:
- Το Theme (wp-content/themes/webeez/)
- Το Plugin (wp-content/plugins/webeez-addons/)

Τι ΕΞΑΙΡΕΙΤΑΙ (Δεν ανεβαίνει ποτέ):
- Τα αρχεία του Docker
- Ο φάκελος assets/src/ του theme
- Ο φάκελος node_modules
