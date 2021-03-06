FROM mysql:5.7

ARG MYSQL_ROOT_PASSWORD=${MYSQL_ROOT_PASSWORD}
ARG MYSQL_USER=${MYSQL_USER}
ARG MYSQL_PASSWORD=${MYSQL_PASSWORD}
ARG MYSQL_DATABASE=${MYSQL_DATABASE}

ENV MYSQL_ROOT_PASSWORD ${MYSQL_ROOT_PASSWORD}
ENV MYSQL_USER ${MYSQL_USER}
ENV MYSQL_PASSWORD ${MYSQL_PASSWORD}
ENV MYSQL_DATABASE ${MYSQL_DATABASE}

EXPOSE 3306 33060
CMD ["mysqld"]