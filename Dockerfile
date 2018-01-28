FROM leequix/php-cli:latest

MAINTAINER leequix <dev@leequix.xyz>

COPY . /opt/radioactive

WORKDIR /opt/radioactive

RUN wget https://getcomposer.org/download/1.6.2/composer.phar &&\
 php composer.phar update &&\
 php composer.phar install

CMD php index.php