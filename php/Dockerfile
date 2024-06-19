# PHP base image พร้อม Apache
FROM php:apache

WORKDIR /var/www/html

# ติดตั้งส่วนขยาย PHP ที่จำเป็น db
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# ติดตั้งโปรแกรมเพิ่มเติมสำหรับ PHP และ clean up cache
RUN apt-get update && \
    apt-get install -y git zip unzip && \
    apt-get install nano -y && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* /var/cache/apt/*  
  
# ติดตั้ง Composer (เฉพาะครั้งแรกเท่านั้น)
RUN if [ ! -f /usr/local/bin/composer ]; then \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer; \
  fi

# COPY composer.json /usr/local/bin/composer.json
# RUN echo "127.0.0.1 booking.thaimooc.ac.th" >> /etc/hosts

# Expose port 80
EXPOSE 80

# รัน Apache
CMD ["apache2-foreground"]
