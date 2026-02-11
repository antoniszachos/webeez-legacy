# Ξεκινάμε από την επίσημη εικόνα WordPress
FROM wordpress:latest

# 1. ΕΓΚΑΤΑΣΤΑΣΗ ΕΡΓΑΛΕΙΩΝ & PHP ZIP EXTENSION
# Το Composer χρειάζεται το 'unzip' και το PHP zip extension για να μην σκάει
RUN apt-get update && apt-get install -y \
    unzip \
    zip \
    git \
    curl \
    nano \
    less \
    zlib1g-dev \
    libzip-dev \
    && docker-php-ext-install zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 2. ΕΓΚΑΤΑΣΤΑΣΗ WP-CLI
RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar \
    && chmod +x wp-cli.phar \
    && mv wp-cli.phar /usr/local/bin/wp

# --- 3. ΕΓΚΑΤΑΣΤΑΣΗ PHPCS & WP STANDARDS (Fixed) ---
# Φέρνουμε τον Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Ρυθμίζουμε τον Composer να τρέχει ως root χωρίς παράπονα
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV PATH="${PATH}:/root/.composer/vendor/bin"

# Ακολουθία εντολών:
# 1. Επιτρέπουμε το plugin που ρυθμίζει τα paths (Απαραίτητο για Composer 2+)
# 2. Κατεβάζουμε το WPCS (αυτό φέρνει και το PHPCS αυτόματα)
# 3. Καθαρίζουμε την cache για να μικρύνει το image
RUN composer global config --no-plugins allow-plugins.dealerdirect/phpcodesniffer-composer-installer true \
    && composer global require --dev wp-coding-standards/wpcs \
    && composer clear-cache

# Σημείωση: Δεν χρειάζεται πλέον symlink ή config set paths,
# το plugin τα έκανε όλα αυτόματα και το ENV PATH τα έκανε διαθέσιμα παντού.

# 4. ΕΓΚΑΤΑΣΤΑΣΗ NODE.JS (v20) & GULP
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Εγκαθιστούμε το Gulp CLI παγκόσμια
RUN npm install --global gulp-cli
