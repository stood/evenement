INSERT INTO application.category (created_at, name)
VALUES
  (
   '2017-01-01 00:00:00','"fr"=>"Convention", "en"=>"Convention"'
  );

INSERT INTO application.event ( name, enabled, characteristic, timespan, category_id, coordinates)
VALUES
  (
   '"fr"=>"Convention Avril", "en"=>"April convention"', true,'{"address":"24 rue paris"}',
   '["2017-11-01 14:41:00","2018-04-30 23:59:59")', 1,'(48.829660, 2.401509)'
  ),
   (
   '"fr"=>"Convention Mai", "en"=>"May convention"', true,'{"address":"24 rue paris"}',
   '["2018-05-01 14:41:00","2018-05-31 23:59:59")', 1,'(48.829660, 2.401509)'
  );


INSERT INTO application.register ( created_at, event_id, lastname, firstname, email)
VALUES
  ('2017-10-01 13:00:00', 1, 'Doe', 'John', 'johndoe@test.local'),
  ('2017-11-01 13:00:00', 2, 'Doe2', 'John2', 'johndoe2@test.local'),
  ('2017-12-01 13:00:00', 1, 'Foo', 'Bar', 'foobar@test.local');
