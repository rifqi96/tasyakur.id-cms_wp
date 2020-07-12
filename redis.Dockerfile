FROM redis:5-alpine

ARG REDIS_PASSWORD=${REDIS_PASSWORD}

# COPY redis.conf /usr/local/etc/redis/redis.conf
# CMD [ "redis-server", "/usr/local/etc/redis/redis.conf" ]

ENV REDIS_PASSWORD ${REDIS_PASSWORD}

RUN apk update && \
    apk upgrade && \
    apk add --no-cache \
    bash

EXPOSE 6379
CMD ["sh", "-c", "exec redis-server --requirepass \"$REDIS_PASSWORD\""]