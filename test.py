import unittest
import MySQLdb


def add_2_numbers(a, b):
    """
    Assume your function returns the addition of 2 numbers
    """
    return a + b


def connect_db(username, password):
    try:
        db = MySQLdb.connect(host="localhost", user=username, passwd=password, db="db_name")
        return True
    except MySQLdb.MySQLError:
        return False


class SpecialTest(unittest.TestCase):
    def test_add_function(self):
        """
        You want to test if the results of your function is the same as your own answer
        """
        self.assertEqual(add_2_numbers(4, 5), 9)
        self.assertLess(add_2_numbers(4, 7), 13)
        self.assertGreater(add_2_numbers(4, 3), 5)

    def test_db_connect(self):
        """
        You want to test if you can connect to the db
        """
        self.assertTrue(connect_db(username="root", password="right_password"))
        self.assertFalse(connect_db(username="root", password="wrong_password"))

if __name__ == '__main__':
    unittest.main()