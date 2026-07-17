# Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
#
# Licensed under The MIT License
# For full copyright and license information, please see the LICENSE.txt
# Redistributions of files must retain the above copyright notice.
# MIT License (https://opensource.org/licenses/mit-license.php)

CREATE TABLE IF NOT EXISTS i18n (
    id INT NOT NULL AUTO_INCREMENT,
    locale VARCHAR(6) NOT NULL,
    model VARCHAR(255) NOT NULL,
    foreign_key INT(10) NOT NULL,
    field VARCHAR(255) NOT NULL,
    content TEXT,
    PRIMARY KEY (id),
    UNIQUE KEY I18N_LOCALE_FIELD (locale, model, foreign_key, field),
    KEY I18N_FIELD (model, foreign_key, field)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
