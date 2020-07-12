FROM nginx:1.17-alpine

ARG ENVIRONMENT=${ENVIRONMENT}

ENV ENVIRONMENT ${ENVIRONMENT}
ENV WORKDIR /var/www/html
ENV ETCDIR ./etc/nginx
ENV CONFDIR /etc/nginx/conf.d
ENV CONFTEMPLDIR /etc/nginx/conf-template.d

RUN apk update && \
    apk upgrade && \
    apk add --no-cache \
    bash

# Copy out app source code to the container
ADD ./src ${WORKDIR}

COPY ${ETCDIR}/*.conf /etc/nginx/conf-template.d/

# Create nginx log dir
RUN mkdir -p /var/log/nginx

# Override the default.conf nginx file
RUN cp ${CONFTEMPLDIR}/default.conf ${CONFDIR}/default.conf;

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]