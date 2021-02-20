CREATE TABLE `phpvms_strider` (
  `id` int(11) NOT NULL,
  `copyright` varchar(250) NOT NULL,
  `name` varchar(7) NOT NULL,
  `module` varchar(250) NOT NULL,
  `version` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



INSERT INTO `phpvms_strider` (`id`, `copyright`, `name`, `module`, `version`) VALUES
(1, '&copy;', 'Strider', 'Codeshare', 'v2.3');


ALTER TABLE `phpvms_strider`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `phpvms_strider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;
