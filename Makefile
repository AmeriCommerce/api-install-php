NS = examples
IMAGE_NAME = api-install-php
PORTS = -p 80:80
COMPOSER = php /usr/local/bin/composer

.PHONY: build run rm deps

default: build run

build:
	docker build -t $(NS)/$(IMAGE_NAME) .

run:
	docker run --name $(IMAGE_NAME) $(PORTS) $(NS)/$(IMAGE_NAME)

rm:
	docker rm -f $(IMAGE_NAME)

deps:
	cd src && $(COMPOSER) install