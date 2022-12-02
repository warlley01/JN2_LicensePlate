#!/bin/bash

bin/magento maintenance:enable && \
bin/magento setup:upgrade && \
bin/magento setup:di:compile && \
rm -rf var/view_preprocessed/ pub/static/* && \
bin/magento setup:static-content:deploy -f pt_BR en_US && \
bin/magento maintenance:disable && \
bin/magento indexer:reindex && \
bin/magento cache:enable && \
bin/magento cache:clean && \
bin/magento cache:flush
