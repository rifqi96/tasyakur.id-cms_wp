FROM alpine:3.7

# Install required apk packages
RUN apk update && \
    apk upgrade && \
    apk add --no-cache \
    bash \
    beanstalkd && \
    rm -rf /var/cache/apk/*

# Create beanstalkd log folder
RUN mkdir -p /var/beanstalkd/data

# Copy the conf
# COPY ./etc/beanstalkd/default.conf /etc/supervisor/conf.d/beanstalkd.conf

# Expose port:
# - 11300 (beanstalkd)
EXPOSE 11300

# Run beanstalkd under supervisor to autorestart if it's exhausted
# CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/conf.d/beanstalkd.conf"]
CMD ["bash", "-c", "/usr/bin/beanstalkd -f 60000 -b /var/beanstalkd/data"]