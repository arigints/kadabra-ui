OUTDIR := deploy/_output

build-push:
	@docker login -u ${CI_REGISTRY_USER} -p ${CI_REGISTRY_PASSWORD} ${CI_REGISTRY}
	@docker build -t ${IMAGE_REPOSITORY}/${CI_PROJECT_NAME}/${APP_NAME}:${APP_VERSION} -f deploy/ui/Dockerfile .
	@docker push ${IMAGE_REPOSITORY}/${CI_PROJECT_NAME}/${APP_NAME}:${APP_VERSION}