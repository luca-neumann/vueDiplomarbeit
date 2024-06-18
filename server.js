import express from 'express';
import mysql from 'mysql';
import cors from 'cors';

const app = express();
const corsOptions = {
  origin: '*', // Erlaubt Anfragen von allen Quellen. Für mehr Sicherheit, spezifische URL angeben.
  optionsSuccessStatus: 200
};

app.use(cors(corsOptions));
app.use(express.json());

const db = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: '', // Leer lassen, wenn kein Passwort gesetzt ist
  database: 'sensordaten_ubicom'
});

db.connect(err => {
  if (err) {
    console.error('Error connecting to the database:', err);
    return;
  }
  console.log('Connected to the database.');
});

app.get('/api/data', (req, res) => {
  const query = 'SELECT ID, Wert, Time, Client FROM pm10';
  db.query(query, (err, results) => {
    if (err) {
      console.error('Error fetching data:', err);
      res.status(500).send('Error fetching data');
    } else {
      res.json(results);
    }
  });
});

const PORT = process.env.PORT || 3000; // Ändern Sie den Port hier
app.listen(PORT, () => {
  console.log(`Server running on port ${PORT}`);
});
