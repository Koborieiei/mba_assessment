import React from "react";
import {
  Select,
  Typography,
  Card,
  CardContent,
  FormControl,
  InputLabel,
  MenuItem,
  TextField,
} from "@material-ui/core";
import { makeStyles } from "@material-ui/core/styles";

import { useForm, Controller } from "react-hook-form";

const useStyles = makeStyles((theme) => ({
  root: {
    minWidth: 275,
    marginTop: 20,
  },
  selectElement: {
    width: "100%",
  },
  //   formControl: {
  //     // width: 30,
  //     height: 200,
  //   },
  title: {
    fontSize: 24,
  },
}));

export default function TeacherSelector({ assess, teacherLists, register }) {
  const classes = useStyles();
  // const { register } = useForm();
  return (
    <Card className={classes.root}>
      <CardContent>
        <Typography className={classes.title} gutterBottom>
          เลือกอาจารย์ผู้สอน
        </Typography>

        <FormControl fullWidth={true} variant="outlined">
          <InputLabel htmlFor="age-native-simple">อาจารย์ผู้สอน</InputLabel>
          <Controller
            rules={{ required: true }}
            control={assess}
            name="selectedteacher"
            defaultValue=""
            render={({
              field,
              fieldState: { invalid, isTouched, isDirty, error },
            }) => (
              <div>
                <Select
                  label="อาจารย์ผู้สอน"
                  className={classes.selectElement}
                  native
                  {...field}
                >
                  <option value="" aria-label="none"></option>
                  {teacherLists.map((teacher, index) => (
                    <option key={index} value={teacher[0]}>
                      {teacher[1]} {teacher[2]}
                    </option>
                  ))}
                </Select>

                {error && (
                  <Typography color="error" component="p">
                    ไม่สามารถเว้นว่างได้
                  </Typography>
                )}
              </div>
            )}
          />
        </FormControl>
      </CardContent>
    </Card>
  );
}
