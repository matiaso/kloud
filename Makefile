.PHONY: all
all:
	$(MAKE) -C environments/orocommerce-ee@2.6 build push
	$(MAKE) -C environments/orocommerce-ee@3.1 build push
	$(MAKE) -C environments/oroplatform-ce@4.1 build push
	$(MAKE) -C environments/oroplatform-ce@3.1 build push
	$(MAKE) -C environments/oroplatform-ee@3.1 build push
	$(MAKE) -C environments/oroplatform-ee@4.1 build push
	$(MAKE) -C environments/orocrm-ce@3.1 build push
	$(MAKE) -C environments/orocrm-ee@3.1 build push

.PHONY: push
push:
	$(MAKE) -C environments/orocommerce-ee@2.6 push
	$(MAKE) -C environments/orocommerce-ee@3.1 push
	$(MAKE) -C environments/oroplatform-ce@4.1 push
	$(MAKE) -C environments/oroplatform-ce@3.1 push
	$(MAKE) -C environments/oroplatform-ee@3.1 push
	$(MAKE) -C environments/oroplatform-ee@4.1 push
	$(MAKE) -C environments/orocrm-ce@3.1 push
	$(MAKE) -C environments/orocrm-ee@3.1 push