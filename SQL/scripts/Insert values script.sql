insert into Airline(Id, Name)
values ('AB', 'Air Berlin'), ('AJ', 'Air Japan'), ('AM', 'Air Madagascar'), ('AA', 'American Airlines'),
	   ('BA', 'British Airways'), ('DA', 'Delta Airlines'), ('JB', 'JetBlue Airways'), ('LA', 'Lufthansa'), 
	   ('SA', 'Southwest Airlines'), ('UA', 'United Airlines');

insert into airport(Id, name, city, country)
values ('BTA', 'Berlin Tegel', 'Berlin', 'Germany'),
('COI', 'Chicago O''Hare International',	'Chicago',	'Illinois'),
('HJA', 'Hartsfield-Jackson Atlanta Int', 'Atlanta', 'United States of America'),
('IIA', 'Ivato International', 'Antananarivo', 'Madagascar'),
('JFK', 'John F. Kennedy International', 'New York', 'United States of America'),
('LGA', 'LaGuardia', 'New York', 'United States of America'),
('LIA', 'Logan International',	'Boston', 'United States of America'),
('LHA', 'London Heathrow', 'London', 'United Kingdom'),
('LAI', 'Los Angeles International', 'Los Angeles',	'United States of America'),
('SFA', 'San Francisco International', 'San Francisco',	'United States of America'),
('TIA', 'Tokyo International', 'Tokyo',	'Japan');

delete from airport
where Id = 'LAI' OR Id = 'SFA' OR Id = 'LHA';

insert into airport(Id, name, city, country)
values 
('LAX', 'Los Angeles International', 'Los Angeles', 'United States of America'),
('NRT', 'Narita International Airport', 'Tokyo', 'Japan'),
('TNR', 'Ivato Airport', 'Antananarivo', 'Madagascar'),
('SFO', 'San Francisco International', 'San Francisco',	'United States of America'),
('BOS', 'General Edward Lawrence Logan International', 'Boston', 'United States of America'),
('LHR', 'London Heathrow', 'London', 'United Kingdom');

insert into Flight(AirlineID, FlightNo, NoOfSeats, DaysOperating, MinLengthOfStay, MaxLengthOfStay)
values ('AA', '111', '100', '1010100',1,30),
('JB', '111', '150', '1111111',1,45),
('AM', '1337', '33', '0000011',2,15);

insert into Person (Id, FirstName, LastName, Address, City, State, ZipCode)
values
(1, 'Jane', 'Smith', '100 Nicolls Rd', 'Stony Brook', 'New York', 11790), 
(2, 'John', 'Doe', '123 N Fake Street', 'New York', 'New York', 10001), 
(3, 'Rick', 'Astley', '1337 Internet Lane', 'Los Angeles', 'California', 90001), 
(4, 'Anna', 'Mavel', '23 May Ave', 'Stony Brook', 'New York', 11790), 
(5, 'Pattrick', 'Vierra', '12 Book Cr', 'Stony Brook', 'New York', 11790);

insert into Customer(Id, AccountNo, CreditCardNo, Email, CreationDate, Rating)
values
(1, 1008, '5133982398470294', 'awesomejane@ftw.com', '2014-03-09 15:04:05', 6), 
(2, 1009, '6011858729579922', 'jdoe@woot.com', '2014-03-10 23:40:11', 4), 
(3, 1010, '3847019385729475', 'rickroller@rolld.com', '2014-03-11 10:19:29', 10);

insert into employee(Id, SSN, IsManager, StartDate, HourlyRate)
values
(4, 198498472, 0, '2009-02-27', 12),
(5, 968727462, 1, '2010-03-12', 14);

insert into Reservation(ResrNo, ResrDate, BookingFee, TotalFare, RepSSN, AccountNo)
values
(111, '2011-01-04 00:00:00', 120, 1200, 198498472, 1009), 
(222, '2010-11-11 00:00:00', 50, 500, 968727462, 1008),
(333, '2011-01-10 00:00:00', 333.33, 3333.33, 198498472, 1010);

insert into passenger(Id, AccountNo)
values
(1, 1008), 
(2, 1009), 
(3, 1010);


insert into ReservationPassenger(ResrNo, Id, AccountNo, SeatNo, Class, Meal)
values
(111, 2, 1009, '33F', 'Economy', 'Chips'), 
(222, 1, 1008, '13A', 'First', 'Fish and Chips'), 
(333, 3, 1010, '1A', 'First', 'Sushi'); 


insert into leg(AirlineID, FlightNo, LegNo, DepAirportID, ArrAirportID, DepTime, ArrTime, ActualDepTime, ActualArrTime)
values
('AA', 111, 1, 'LGA', 'LAX', '2011-01-05 11:00:00', '2011-01-05 17:00:00', '2011-01-05 11:00:00', '2011-01-05 16:55:00'), 
('AA', 111, 2, 'LAX', 'NRT', '2011-01-05 19:00:00', '2011-01-06 07:30:00', '2011-01-05 19:08:00', '2011-01-06 07:32:00'), 
('AM', 1337, 1, 'JFK', 'TNR', '2011-01-13 07:00:00', '2011-01-13 23:00:00', '2011-01-13 06:55:00', '2011-01-13 22:58:00'), 
('JB', 111, 1, 'SFO', 'BOS', '2011-01-10 14:00:00', '2011-01-10 19:30:00', '2011-01-10 14:10:00', '2011-01-10 19:25:00'), 
('JB', 111, 2, 'BOS', 'LHR', '2011-01-10 22:30:00', '2011-01-11 05:00:00', '2011-01-10 22:30:00', '2011-01-11 05:40:00');

insert into advpurchasediscount(AirlineId, Days, DiscountRate)
values 
('AA', 7, 2.5), 
('AA', 14, 5),
('AA', 30, 7.5), 
('AM', 60, 10), 
('JB', 7, 3),
('JB', 14, 6.5);

insert into fare (AirlineID, FlightNo, FareType, Class, Fare)
values 
('AA', 111, 'ONEWAY', 'Economy', 1200), 
('AM', 1337, 'ONEWAY', 'First', 3333.33), 
('JB', 111, 'ONEWAY', 'First', 500);

insert into customerpreferences(AccountNo, Preference)
values 
(1008, 'Window Seat'), 
(1009, 'Aisle Seat');

insert into includes(ResrNo, AirlineID, FlightNo, LegNo, Date)
values
(111, 'AA', 111, 1, '2011-01-05'), 
(111, 'AA', 111, 2, '2011-01-05'), 
(222, 'JB', 111, 2, '2011-01-14'),
(333, 'AM', 1337, 1, '2011-01-13'); 

insert into auctions(AccountNo, AirlineID, FlightNo, Class, Date, NYOP, Accepted)
values 
(1008, 'AA', 111, 'Economy', '2011-09-09 12:14:15', 500, 1); 



